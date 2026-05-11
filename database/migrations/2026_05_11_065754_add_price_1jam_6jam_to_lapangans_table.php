<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lapangans', function (Blueprint $table) {
            $table->decimal('price_1jam', 10, 2)->nullable()->after('closing_time');
            $table->decimal('price_6jam', 10, 2)->nullable()->after('price_5jam');
        });
    }

    public function down(): void
    {
        Schema::table('lapangans', function (Blueprint $table) {
            $table->dropColumn(['price_1jam', 'price_6jam']);
        });
    }
};
