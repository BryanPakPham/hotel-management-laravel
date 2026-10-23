<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = DB::table('invoices')
            ->join('bookings', 'invoices.booking_id', '=', 'bookings.id')
            ->leftJoin('users', 'invoices.issued_by', '=', 'users.id')
            ->select(
                'invoices.*',
                'bookings.booking_code',
                'bookings.guest_name',
                'bookings.guest_phone',
                'users.name as issuer_name'
            )
            ->orderByDesc('invoices.issued_at')
            ->get();

        $invoices = $invoices->map(function ($invoice) {
            $invoice->paid_amount = DB::table('payments')
                ->where('invoice_id', $invoice->id)
                ->where('status', 'success')
                ->sum('amount');

            $invoice->remaining_amount = max(
                0,
                (float) $invoice->total_amount
                - (float) $invoice->paid_amount
            );

            return $invoice;
        });

        // Cac booking da tra phong va chua co hoa don
        $bookings = DB::table('bookings')
            ->where('bookings.status', 'checked_out')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('invoices')
                    ->whereColumn(
                        'invoices.booking_id',
                        'bookings.id'
                    );
            })
            ->select(
                'bookings.id',
                'bookings.booking_code',
                'bookings.guest_name',
                'bookings.guest_phone'
            )
            ->orderByDesc('bookings.id')
            ->get();

        return view(
            'receptionist.invoices.index',
            compact('invoices', 'bookings')
        );
    }

    /**
     * Lap hoa don cho booking da checkout.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => [
                'required',
                'integer',
                'exists:bookings,id',
            ],
        ]);

        $nhanVienId = auth()->id();

        if (!$nhanVienId) {
            return back()->with(
                'error',
                'Vui long dang nhap bang tai khoan le tan.'
            );
        }

        try {
            $invoiceId = DB::transaction(function () use (
                $request,
                $nhanVienId
            ) {
                $booking = DB::table('bookings')
                    ->where('id', $request->booking_id)
                    ->lockForUpdate()
                    ->first();

                if (!$booking || $booking->status !== 'checked_out') {
                    throw new \RuntimeException(
                        'Chi co the lap hoa don cho booking da tra phong.'
                    );
                }

                $daCoHoaDon = DB::table('invoices')
                    ->where('booking_id', $booking->id)
                    ->exists();

                if ($daCoHoaDon) {
                    throw new \RuntimeException(
                        'Booking nay da co hoa don.'
                    );
                }

                $bookingRooms = DB::table('booking_rooms')
                    ->where('booking_id', $booking->id)
                    ->get();

                if ($bookingRooms->isEmpty()) {
                    throw new \RuntimeException(
                        'Booking khong co phong nao.'
                    );
                }

                $roomCharge = 0;

                foreach ($bookingRooms as $bookingRoom) {
                    $stay = DB::table('stay_records')
                        ->where(
                            'booking_room_id',
                            $bookingRoom->id
                        )
                        ->first();

                    if (
                        !$stay ||
                        !$stay->actual_check_in ||
                        !$stay->actual_check_out
                    ) {
                        throw new \RuntimeException(
                            'Tat ca phong phai check-out truoc khi lap hoa don.'
                        );
                    }

                    $checkIn = \Carbon\Carbon::parse(
                        $stay->actual_check_in
                    )->startOfDay();

                    $checkOut = \Carbon\Carbon::parse(
                        $stay->actual_check_out
                    )->startOfDay();

                    if ($checkOut->lt($checkIn)) {
                        throw new \RuntimeException(
                            'Thoi gian check-out khong hop le.'
                        );
                    }

                    // Toi thieu tinh 1 dem cho moi phong.
                    $soDem = max(
                        1,
                        (int) $checkIn->diffInDays($checkOut)
                    );

                    $roomCharge +=
                        $soDem * (float) $bookingRoom->price_per_night;
                }

                $serviceCharge = DB::table('booking_services')
                    ->join(
                        'stay_records',
                        'booking_services.stay_record_id',
                        '=',
                        'stay_records.id'
                    )
                    ->join(
                        'booking_rooms',
                        'stay_records.booking_room_id',
                        '=',
                        'booking_rooms.id'
                    )
                    ->where(
                        'booking_rooms.booking_id',
                        $booking->id
                    )
                    ->sum('booking_services.total_price');

                $roomCharge = round($roomCharge, 2);
                $serviceCharge = round((float) $serviceCharge, 2);
                $discount = 0;
                $tax = 0;

                $totalAmount = max(
                    0,
                    round(
                        $roomCharge + $serviceCharge - $discount + $tax,
                        2
                    )
                );

                do {
                    $invoiceNumber = 'HD'
                        . now()->format('YmdHis')
                        . strtoupper(Str::random(4));
                } while (
                    DB::table('invoices')
                        ->where('invoice_number', $invoiceNumber)
                        ->exists()
                );

                return DB::table('invoices')->insertGetId([
                    'invoice_number' => $invoiceNumber,
                    'booking_id' => $booking->id,
                    'issued_by' => $nhanVienId,
                    'room_charge' => $roomCharge,
                    'service_charge' => $serviceCharge,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total_amount' => $totalAmount,
                    'status' => 'unpaid',
                    'issued_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            return redirect()
                ->route('receptionist.invoices.show', $invoiceId)
                ->with('success', 'Lap hoa don thanh cong.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with(
                'error',
                $e instanceof \RuntimeException
                    ? $e->getMessage()
                    : 'Khong the lap hoa don. Vui long kiem tra du lieu.'
            );
        }
    }

    /**
     * Chi tiet hoa don.
     */
    public function show($id)
    {
        $invoice = DB::table('invoices')
            ->join('bookings', 'invoices.booking_id', '=', 'bookings.id')
            ->leftJoin('users', 'invoices.issued_by', '=', 'users.id')
            ->where('invoices.id', $id)
            ->select(
                'invoices.*',
                'bookings.booking_code',
                'bookings.guest_name',
                'bookings.guest_phone',
                'users.name as issuer_name'
            )
            ->first();

        abort_if(!$invoice, 404, 'Khong tim thay hoa don.');

        $invoice->paid_amount = DB::table('payments')
            ->where('invoice_id', $invoice->id)
            ->where('status', 'success')
            ->sum('amount');

        $invoice->remaining_amount = max(
            0,
            (float) $invoice->total_amount
            - (float) $invoice->paid_amount
        );

        $rooms = DB::table('booking_rooms')
            ->join(
                'rooms',
                'booking_rooms.room_id',
                '=',
                'rooms.id'
            )
            ->leftJoin(
                'stay_records',
                'booking_rooms.id',
                '=',
                'stay_records.booking_room_id'
            )
            ->where('booking_rooms.booking_id', $invoice->booking_id)
            ->select(
                'booking_rooms.id',
                'booking_rooms.price_per_night',
                'rooms.room_number',
                'stay_records.actual_check_in',
                'stay_records.actual_check_out'
            )
            ->get()
            ->map(function ($room) {
                $room->nights = 0;
                $room->subtotal = 0;

                if (
                    $room->actual_check_in &&
                    $room->actual_check_out
                ) {
                    $start = \Carbon\Carbon::parse(
                        $room->actual_check_in
                    )->startOfDay();

                    $end = \Carbon\Carbon::parse(
                        $room->actual_check_out
                    )->startOfDay();

                    $room->nights = max(
                        1,
                        (int) $start->diffInDays($end)
                    );

                    $room->subtotal = round(
                        $room->nights * (float) $room->price_per_night,
                        2
                    );
                }

                return $room;
            });

        $services = DB::table('booking_services')
            ->join(
                'services',
                'booking_services.service_id',
                '=',
                'services.id'
            )
            ->join(
                'stay_records',
                'booking_services.stay_record_id',
                '=',
                'stay_records.id'
            )
            ->join(
                'booking_rooms',
                'stay_records.booking_room_id',
                '=',
                'booking_rooms.id'
            )
            ->leftJoin(
                'rooms',
                'booking_rooms.room_id',
                '=',
                'rooms.id'
            )
            ->where('booking_rooms.booking_id', $invoice->booking_id)
            ->select(
                'booking_services.*',
                'services.name as service_name',
                'services.unit',
                'rooms.room_number'
            )
            ->orderBy('booking_services.used_at')
            ->get();

        $payments = DB::table('payments')
            ->leftJoin('users', 'payments.received_by', '=', 'users.id')
            ->where('payments.invoice_id', $invoice->id)
            ->select(
                'payments.*',
                'users.name as receiver_name'
            )
            ->orderByDesc('payments.paid_at')
            ->get();

        return view(
            'receptionist.invoices.show',
            compact('invoice', 'rooms', 'services', 'payments')
        );
    }

    /**
     * Ghi nhan mot khoan thanh toan thanh cong.
     */
    public function storePayment(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => [
                'required',
                \Illuminate\Validation\Rule::in([
                    'cash',
                    'bank_transfer',
                    'card',
                    'vnpay',
                    'momo',
                ]),
            ],
            'transaction_ref' => 'nullable|string|max:100',
        ]);

        $nhanVienId = auth()->id();

        if (!$nhanVienId) {
            return back()->with(
                'error',
                'Vui long dang nhap truoc khi ghi nhan thanh toan.'
            );
        }

        try {
            DB::transaction(function () use (
                $validated,
                $id,
                $nhanVienId
            ) {
                $invoice = DB::table('invoices')
                    ->where('id', $id)
                    ->lockForUpdate()
                    ->first();

                if (!$invoice) {
                    throw new \RuntimeException(
                        'Khong tim thay hoa don.'
                    );
                }

                if ($invoice->status === 'refunded') {
                    throw new \RuntimeException(
                        'Hoa don da hoan tien, khong the thanh toan.'
                    );
                }

                $paidAmount = (float) DB::table('payments')
                    ->where('invoice_id', $invoice->id)
                    ->where('status', 'success')
                    ->sum('amount');

                $remaining = round(
                    (float) $invoice->total_amount - $paidAmount,
                    2
                );

                $amount = round((float) $validated['amount'], 2);

                if ($remaining <= 0) {
                    throw new \RuntimeException(
                        'Hoa don da duoc thanh toan du.'
                    );
                }

                if ($amount > $remaining) {
                    throw new \RuntimeException(
                        'So tien thanh toan vuot qua so tien con no.'
                    );
                }

                DB::table('payments')->insert([
                    'invoice_id' => $invoice->id,
                    'received_by' => $nhanVienId,
                    'amount' => $amount,
                    'method' => $validated['method'],
                    'transaction_ref' =>
                        $validated['transaction_ref'] ?? null,
                    'status' => 'success',
                    'paid_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $newPaidAmount = round($paidAmount + $amount, 2);

                $newStatus = $newPaidAmount >= (float) $invoice->total_amount
                    ? 'paid'
                    : 'partial';

                DB::table('invoices')
                    ->where('id', $invoice->id)
                    ->update([
                        'status' => $newStatus,
                        'updated_at' => now(),
                    ]);
            });

            return redirect()
                ->route('receptionist.invoices.show', $id)
                ->with('success', 'Ghi nhan thanh toan thanh cong.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with(
                'error',
                $e instanceof \RuntimeException
                    ? $e->getMessage()
                    : 'Khong the ghi nhan thanh toan. Vui long thu lai.'
            );
        }
    }
}
