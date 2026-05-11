<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // ← tambahkan ini

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::today()->startOfMonth();
        $endDate   = $request->end_date   ? Carbon::parse($request->end_date)   : Carbon::today()->endOfMonth();
        $status    = $request->status;

        $query = Booking::whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->where('payment_status', 'paid');

        if ($status && in_array($status, ['cash', 'qris'])) {
            $query->where('payment_method', $status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        $totalPendapatan = $transactions->sum('total_price');
        $totalTransaksi = $transactions->count();

        return view('admin.laporan-keuangan', compact('transactions', 'totalPendapatan', 'totalTransaksi', 'startDate', 'endDate', 'status'));
    }

    // Tambahan method untuk export PDF
    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::today()->startOfMonth();
        $endDate   = $request->end_date   ? Carbon::parse($request->end_date)   : Carbon::today()->endOfMonth();
        $status    = $request->status;

        $query = Booking::with(['user', 'lapangan'])
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->where('payment_status', 'paid');

        if ($status && in_array($status, ['cash', 'qris'])) {
            $query->where('payment_method', $status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        $totalPendapatan = $transactions->sum('total_price');

        $pdf = Pdf::loadView('admin.keuangan-pdf', compact('transactions', 'totalPendapatan', 'startDate', 'endDate', 'status'));
        return $pdf->stream('laporan_keuangan_' . date('Y-m-d') . '.pdf');
    }
}