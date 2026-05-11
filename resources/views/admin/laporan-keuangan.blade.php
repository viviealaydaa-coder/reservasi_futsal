@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@push('styles')
<style>
    /* Tabel seragam dengan halaman kelola booking */
    .table-arena {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #0f5132;
    }
    .table-arena thead tr {
        background: linear-gradient(90deg, #b84500, #e85d00, #ff7a1a, #ff9a4a);
    }
    .table-arena thead th {
        padding: 12px;
        text-align: left;
        font-weight: bold;
        color: white;
        border: 1px solid #0f5132;
        white-space: nowrap;
    }
    .table-arena tbody tr:nth-child(even) {
        background-color: #ffffff;
    }
    .table-arena tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }
    .table-arena tbody tr:hover {
        background-color: #ffe5d0;
    }
    .table-arena tbody td {
        padding: 10px 12px;
        color: #1a1a1a;
        vertical-align: middle;
        font-size: 13px;
        border: 1px solid #0f5132;
    }
    
    /* FILTER PANEL DENGAN BACKGROUND HITAM */
    .filter-panel {
        background: #0f0f0f;  /* hitam/gelap */
        border: 1px solid #2a2a2a;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
    }
    .filter-panel .form-label {
        color: #aaa;
    }
    .filter-panel .form-control,
    .filter-panel .form-select {
        background: #ffffff;  /* putih */
        border: 1px solid #d1d5db;
        color: #1f2937;
        border-radius: 10px;
        padding: 10px 14px;
    }
    .filter-panel .form-control:focus,
    .filter-panel .form-select:focus {
        border-color: #e85d00;
        box-shadow: 0 0 0 3px rgba(232,93,0,0.15);
    }
    
    .btn-gradient {
        background: linear-gradient(90deg, #b84500, #e85d00, #ff7a1a);
        border: none;
        padding: 8px 20px;
        border-radius: 30px;
        color: white;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
    .btn-gradient:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-family:'Montserrat',sans-serif; font-weight:800; color:#f0f0f0;">Laporan Keuangan</h2>
        <a href="{{ url('/admin/keuangan/pdf?' . http_build_query(request()->query())) }}" class="btn-gradient" target="_blank">
            <i class="fas fa-file-pdf"></i> Cetak PDF
        </a>
    </div>

    {{-- FILTER --}}
    <div class="filter-panel">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate instanceof \DateTime ? $startDate->format('Y-m-d') : date('Y-m-d', strtotime($startDate)) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate instanceof \DateTime ? $endDate->format('Y-m-d') : date('Y-m-d', strtotime($endDate)) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Metode Pembayaran</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="cash" {{ ($status ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="qris" {{ ($status ?? '') == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn-gradient w-100">Filter</button>
            </div>
        </form>
    </div>

    {{-- ALERT TOTAL PENDAPATAN DAN TRANSACTION DIHAPUS --}}

    {{-- TABEL TRANSAKSI --}}
    <div class="table-responsive">
        <table class="table-arena">
            <thead>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <th>Kode Booking</th>
                    <th>Penyewa</th>
                    <th>Lapangan</th>
                    <th>Metode</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions ?? [] as $t)
                <tr>
                    <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td><span style="font-family:monospace; color:#e85d00;">{{ $t->booking_code }}</span></td>
                    <td>{{ $t->user->name }}</td>
                    <td>{{ $t->lapangan->name }}</td>
                    <td>{{ strtoupper($t->payment_method) }}</td>
                    <td style="font-weight:600;">Rp {{ number_format($t->total_price) }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Tidak ada transaksi dalam rentang ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection