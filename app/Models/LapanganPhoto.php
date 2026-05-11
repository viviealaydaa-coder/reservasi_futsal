<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LapanganPhoto extends Model
{
    protected $fillable = ['lapangan_id', 'photo_path', 'sort_order'];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}