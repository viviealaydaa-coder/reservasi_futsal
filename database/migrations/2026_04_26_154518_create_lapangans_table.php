<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['indoor', 'outdoor']);
            $table->text('description')->nullable();
            $table->decimal('price_2jam', 10, 2)->default(80000);
            $table->decimal('price_3jam', 10, 2)->default(130000);
            $table->decimal('price_4jam', 10, 2)->default(170000);
            $table->decimal('price_5jam', 10, 2)->default(200000);
            $table->time('opening_time')->default('07:00');
            $table->time('closing_time')->default('23:00');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};