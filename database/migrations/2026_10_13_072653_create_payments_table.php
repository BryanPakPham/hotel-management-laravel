
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')
                ->constrained('invoices')
                ->restrictOnDelete();

            $table->foreignId('received_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('amount', 12, 2);

            $table->enum('method', [
                'cash',
                'bank_transfer',
                'card',
                'vnpay',
                'momo'
            ]);

            $table->string('transaction_ref')->nullable();

            $table->enum('status', [
                'pending',
                'success',
                'failed',
                'refunded'
            ]);

            $table->dateTime('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
