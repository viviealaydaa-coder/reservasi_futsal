<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LapanganPhotoSeeder extends Seeder
{
    public function run(): void
    {
        $photos = [
            ['lapangan_id' => 1, 'photo_path' => 'lapangan/kickin_standard.png',   'sort_order' => 1],
            ['lapangan_id' => 2, 'photo_path' => 'lapangan/kickin_premium.png',     'sort_order' => 1],
            ['lapangan_id' => 3, 'photo_path' => 'lapangan/kickin_outdoor.png',     'sort_order' => 1],
            ['lapangan_id' => 4, 'photo_path' => 'lapangan/kickin_pro_arena.png',   'sort_order' => 1],
            ['lapangan_id' => 5, 'photo_path' => 'lapangan/kickin_mini_soccer.png', 'sort_order' => 1],
            ['lapangan_id' => 6, 'photo_path' => 'lapangan/kickin_executive.png',   'sort_order' => 1],
            ['lapangan_id' => 7, 'photo_path' => 'lapangan/kickin_green_field.png', 'sort_order' => 1],
        ];

        DB::table('lapangan_photos')->insert($photos);
    }
}