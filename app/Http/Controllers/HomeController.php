<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;

class HomeController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::where('is_active', true)->limit(3)->get();
        return view('home', compact('lapangans'));
    }
}