<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Booking menunggu verifikasi (prioritas)
        $needVerificationBookings = Booking::with(['user', 'lapangan'])
            ->where('payment_status', 'waiting_confirmation')
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();

        // 2. Booking hari ini (untuk okupansi)
        $todayBookings = Booking::with(['user', 'lapangan'])
            ->whereDate('booking_date', today())
            ->whereNotIn('payment_status', ['cancelled'])
            ->orderBy('start_time', 'asc')
            ->get();

        // 3. Hitung total lapangan aktif
        $activeLapangans = Lapangan::where('is_active', true)->count();

        // 4. Riwayat verifikasi terbaru (5 data terakhir)
        $recentVerified = Booking::with(['user', 'lapangan', 'verifier'])
            ->whereNotNull('payment_verified_at')
            ->orderBy('payment_verified_at', 'desc')
            ->limit(5)
            ->get();

        // 5. Hitung jumlah pending verifikasi (untuk badge di header)
        $pendingVerification = Booking::where('payment_status', 'waiting_confirmation')->count();

        return view('admin.dashboard', compact(
            'needVerificationBookings',
            'todayBookings',
            'recentVerified',
            'pendingVerification'
        ));
    }
}