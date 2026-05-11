<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lapangan_id')->constrained()->onDelete('cascade');
            $table->date('booking_date');
            $table->time('start_time');
            $table->integer('duration_hours');
            $table->time('end_time');
            $table->decimal('price_per_period', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_method', ['cash', 'qris']);
            $table->enum('payment_status', ['pending', 'waiting_confirmation', 'paid', 'failed', 'cancelled', 'completed'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->text('payment_notes')->nullable();
            $table->timestamp('payment_verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('damage_notes')->nullable();
            $table->decimal('damage_fee', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};