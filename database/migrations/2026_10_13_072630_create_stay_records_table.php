
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stay_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_room_id')
                ->unique()
                ->constrained('booking_rooms')
                ->restrictOnDelete();

            $table->foreignId('checked_in_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('checked_out_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('actual_check_in');
            $table->dateTime('actual_check_out')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stay_records');
    }
};
