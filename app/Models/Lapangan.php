<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'lapangans';
    protected $fillable = [
        'name', 'type', 'description', 'price_2jam', 'price_3jam', 'price_4jam', 'price_5jam',
        'opening_time', 'closing_time', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function photos()
    {
        return $this->hasMany(LapanganPhoto::class)->orderBy('sort_order');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getPriceForHours($hours)
    {
        return match ($hours) {
            2 => $this->price_2jam,
            3 => $this->price_3jam,
            4 => $this->price_4jam,
            5 => $this->price_5jam,
            default => 0,
        };
    }
}