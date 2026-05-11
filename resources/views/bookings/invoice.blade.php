@extends('layouts.app')

@section('title', 'Struk Booking')

@section('content')
<div class="container my-4 d-flex justify-content-center">
    <div class="card shadow-sm" style="max-width: 420px; width: 100%; position: relative;">
        {{-- Tombol Cetak --}}
        <div style="text-align: right; margin-bottom: 12px;">
            <button onclick="window.print()" style="background:#E85D00; color:white; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; font-size:13px;">
                <i class="fas fa-print me-1"></i> Cetak Invoice
            </button>
        </div>

        <div class="card-body p-4" style="background: #fff; font-family: 'Courier New', monospace; color: #000;">
            
            <!-- Header -->
            <div class="text-center mb-3">
                <h3 class="mb-0 fw-bold" style="color: #000;">KICKIN</h3>
                <p class="mb-0 small" style="color: #000;">Book It, Own It</p>
                <p class="mb-0 small" style="color: #000;">0812345678912</p>
                <hr class="my-2" style="border-color: #000;">
            </div>

            <!-- Kode Booking -->
            <div class="text-center mb-3">
                <h4 class="fw-bold" style="color: #000;">#{{ $booking->booking_code }}</h4>
            </div>

            <hr class="my-2" style="border-color: #000;">

            <!-- Info Transaksi -->
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span style="color: #000;"><strong>Tanggal Transaksi</strong></span>
                    <span style="color: #000;">{{ $booking->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="color: #000;"><strong>Tanggal Booking</strong></span>
                    <span style="color: #000;">{{ $booking->booking_date->format('d/m/Y') }}</span>
                </div>
            </div>

            <hr class="my-2" style="border-color: #000;">

            <!-- Info Pelanggan -->
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span style="color: #000;"><strong>Nama</strong></span>
                    <span style="color: #000;">{{ $booking->user->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="color: #000;"><strong>No. Telepon</strong></span>
                    <span style="color: #000;">{{ $booking->user->phone ?? '-' }}</span>
                </div>
            </div>

            <hr class="my-2" style="border-color: #000;">

            <!-- Detail Booking -->
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span style="color: #000;"><strong>Lapangan</strong></span>
                    <span style="color: #000;">{{ $booking->lapangan->name }} ({{ $booking->lapangan->type }})</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="color: #000;"><strong>Jam</strong></span>
                    <span style="color: #000;">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="color: #000;"><strong>Durasi</strong></span>
                    <span style="color: #000;">{{ $booking->duration_hours }} jam</span>
                </div>
            </div>

            <hr class="my-2" style="border-color: #000;">

            <!-- TOTAL -->
            <div class="d-flex justify-content-between mb-2">
                <span style="color: #000;"><strong>TOTAL</strong></span>
                <span style="color: #000;"><strong>Rp {{ number_format($booking->total_price) }}</strong></span>
            </div>

            @if(($booking->damage_fee ?? 0) > 0)
            <div class="d-flex justify-content-between mb-1 small">
                <span style="color: #000;">Denda</span>
                <span style="color: #000;">Rp {{ number_format($booking->damage_fee) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span style="color: #000;"><strong>TOTAL + Denda</strong></span>
                <span style="color: #000;"><strong>Rp {{ number_format($booking->total_price + $booking->damage_fee) }}</strong></span>
            </div>
            @endif

            <hr class="my-2" style="border-color: #000;">

            <!-- Status & Metode -->
            <div class="d-flex justify-content-between mb-1">
                <span style="color: #000;"><strong>Status Bayar</strong></span>
                <span style="color: #000;">{{ $booking->payment_status == 'paid' ? 'LUNAS' : strtoupper($booking->payment_status) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span style="color: #000;"><strong>Metode</strong></span>
                <span style="color: #000;">{{ strtoupper($booking->payment_method) }}</span>
            </div>

            <hr class="my-3" style="border-color: #000;">

            <!-- Footer -->
            <div class="text-center mt-2">
                <p class="mb-0 small" style="color: #000;">Terima Kasih Sudah Bermain di</p>
                <p class="fw-bold mb-0" style="color: #000;">KICKIN!</p>
                <p class="small mt-2" style="color: #000;">⭐ Book It, Own It ⭐</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card-body, .card-body * {
            visibility: visible;
        }
        .card {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }
        .container {
            margin: 0 !important;
            padding: 0 !important;
        }
        nav, footer, .navbar, .btn, .d-print-none, .btn-cetak {
            display: none !important;
        }
        /* Tombol cetak disembunyikan saat print */
        button[onclick="window.print()"] {
            display: none !important;
        }
    }
</style>
@endsection