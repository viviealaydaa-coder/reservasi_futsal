<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::with('photos')->where('is_active', true)->paginate(6);        return view('lapangans.index', compact('lapangans'));
    }

    public function show($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('lapangans.show', compact('lapangan'));
    }
}