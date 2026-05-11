<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lapangan_photos', function (Blueprint $table) {
            $table->unsignedBigInteger('lapangan_id')->after('id');
            $table->string('photo_path')->after('lapangan_id');
            $table->integer('sort_order')->default(0)->after('photo_path');

            $table->foreign('lapangan_id')->references('id')->on('lapangans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('lapangan_photos', function (Blueprint $table) {
            $table->dropForeign(['lapangan_id']);
            $table->dropColumn(['lapangan_id', 'photo_path', 'sort_order']);
        });
    }
};