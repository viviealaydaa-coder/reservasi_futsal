<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function transaksi()
    {
        // ambil data transaksi yang sudah lunas (paid) atau selesai (completed)
        $transaksis = Booking::with(['lapangan'])
            ->whereIn('payment_status', ['paid', 'completed'])
            ->orderBy('booking_date', 'desc')
            ->get();

        $totalPendapatan = $transaksis->sum('total_price');

        $data = [
            'transaksis' => $transaksis,
            'totalPendapatan' => $totalPendapatan,
            'tanggal' => now()->format('d F Y H:i')
        ];

        $pdf = Pdf::loadView('admin.laporan.transaksi-pdf', $data);
        return $pdf->download('laporan_transaksi_' . date('Y-m-d') . '.pdf');
    }
}