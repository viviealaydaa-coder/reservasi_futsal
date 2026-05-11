<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code', 'user_id', 'lapangan_id', 'booking_date', 'start_time',
        'duration_hours', 'end_time', 'price_per_period', 'total_price',
        'payment_method', 'payment_status', 'payment_proof', 'payment_notes',
        'payment_verified_at', 'verified_by', 'damage_notes', 'damage_fee'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'payment_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Generate kode booking unik
    public static function generateBookingCode()
    {
        return 'FUT-'.strtoupper(uniqid());
    }
}