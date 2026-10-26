
<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomTypeController as AdminRoomTypeController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\AmenityController as AmenityController;
use App\Http\Controllers\Admin\ServiceController as ServiceController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\RoomController;
use App\Http\Controllers\Receptionist\BookingController as ReceptionistBookingController;
use App\Http\Controllers\Receptionist\StayController as ReceptionistStayController;
use App\Http\Controllers\Receptionist\ServiceController as ReceptionistServiceController;
use App\Http\Controllers\Receptionist\InvoiceController as ReceptionistInvoiceController;

use App\Http\Controllers\Auth\LoginController;

// Trang chủ và phòng có thể xem trước khi đăng nhập.
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/highlights', [HomeController::class, 'highlights'])->name('highlights');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{roomType:slug}', [RoomController::class, 'show'])->name('rooms.show');

// Đăng nhập
Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

// Đăng xuất
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Đăng ký tài khoản khách hàng
Route::get('/register', [RegisterController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.store');


// Khu vực Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/rooms', [AdminRoomController::class, 'index'])
            ->name('rooms.index');

        Route::resource('rooms', AdminRoomController::class)
            ->except(['index', 'show']);

        // Quản lý loại phòng
        Route::resource('room-types', AdminRoomTypeController::class)
            ->except(['show'])
            ->parameters(['room-types' => 'roomType']);

        //Quản lý đặt phòng
        Route::get('/bookings', [AdminBookingController::class, 'index'])
            ->name('bookings.index');
        //chi tiết thông tin đặt phòng
        Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])
            ->whereNumber('id')
            ->name('bookings.show');
        //xác nhận đặt phòng
        Route::patch('/bookings/{id}/confirm', [
            AdminBookingController::class,
            'confirm'
        ])->whereNumber('id')->name('bookings.confirm');
        //hủy đặt phòng
        Route::patch('/bookings/{id}/cancel', [
            AdminBookingController::class,
            'cancel'
        ])->whereNumber('id')->name('bookings.cancel');

        //quản lí khách hàng

        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])
            ->whereNumber('id')
            ->name('users.show');

        Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])
            ->whereNumber('id')
            ->name('users.edit');

        Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])
            ->whereNumber('id')
            ->name('users.update');

        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])
            ->whereNumber('id')
            ->name('users.destroy');

        Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])
            ->name('users.store');

        // Quản lý tiện nghi
        Route::get('/amenities', [AmenityController::class, 'index'])
            ->name('amenities.index');

        Route::get('/amenities/create', [AmenityController::class, 'create'])
            ->name('amenities.create');

        Route::post('/amenities', [AmenityController::class, 'store'])
            ->name('amenities.store');

        Route::get('/amenities/{id}/edit', [AmenityController::class, 'edit'])
            ->whereNumber('id')
            ->name('amenities.edit');

        Route::put('/amenities/{id}', [AmenityController::class, 'update'])
            ->whereNumber('id')
            ->name('amenities.update');

        Route::delete('/amenities/{id}', [AmenityController::class, 'destroy'])
            ->whereNumber('id')
            ->name('amenities.destroy');

        // Quản lý dịch vụ
        Route::get('/services', [ServiceController::class, 'index'])
            ->name('services.index');

        Route::get('/services/create', [ServiceController::class, 'create'])
            ->name('services.create');

        Route::post('/services', [ServiceController::class, 'store'])
            ->name('services.store');

        Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])
            ->whereNumber('id')
            ->name('services.edit');

        Route::put('/services/{id}', [ServiceController::class, 'update'])
            ->whereNumber('id')
            ->name('services.update');

        Route::delete('/services/{id}', [ServiceController::class, 'destroy'])
            ->whereNumber('id')
            ->name('services.destroy');
    });

// Khu vực Lễ tân
Route::middleware(['auth', 'role:receptionist'])
    ->prefix('receptionist')
    ->name('receptionist.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('receptionist.dashboard');
        })->name('dashboard');

        Route::get('/bookings', [
            ReceptionistBookingController::class,
            'index'
        ])->name('bookings.index');

        Route::get('/bookings/{id}', [
            ReceptionistBookingController::class,
            'show'
        ])->name('bookings.show');

        Route::post('/bookings/{id}/confirm', [
            ReceptionistBookingController::class,
            'confirm'
        ])->name('bookings.confirm');

        Route::get('/stays', [ReceptionistStayController::class, 'index'])
            ->name('stays.index');

        Route::post('/stays/{id}/check-in', [ReceptionistStayController::class, 'checkIn'])
            ->name('stays.checkIn');

        Route::post('/stays/{id}/check-out', [ReceptionistStayController::class, 'checkOut'])
            ->name('stays.checkOut');

        Route::get('/services', [
            ReceptionistServiceController::class,
            'index'
        ])->name('services.index');

        Route::post('/services', [
            ReceptionistServiceController::class,
            'store'
        ])->name('services.store');

        Route::get('/invoices', [
            ReceptionistInvoiceController::class,
            'index'
        ])->name('invoices.index');

        Route::post('/invoices', [
            ReceptionistInvoiceController::class,
            'store'
        ])->name('invoices.store');

        Route::get('/invoices/{id}', [
            ReceptionistInvoiceController::class,
            'show'
        ])->name('invoices.show');

        Route::post('/invoices/{id}/payments', [
            ReceptionistInvoiceController::class,
            'storePayment'
        ])->name('invoices.payments.store');
    });

// Khu vực Khách hàng
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])
            ->name('dashboard');

        Route::get('/bookings', [BookingController::class, 'index'])
            ->name('bookings.index');

        Route::get('/bookings/create', [BookingController::class, 'create'])
            ->name('bookings.create');

        Route::post('/bookings', [BookingController::class, 'store'])
            ->name('bookings.store');

        Route::get('/bookings/{booking}', [BookingController::class, 'show'])
            ->name('bookings.show');
    });
Route::get('/test-bookings', [
    ReceptionistBookingController::class,
    'index'
])->name('test.bookings.index');

Route::get('/test-bookings/{id}', [
    ReceptionistBookingController::class,
    'show'
])->whereNumber('id')->name('test.bookings.show');
