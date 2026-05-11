@extends('layouts.app')

@section('title', 'History Booking')

@push('styles')
<style>
    .history-header {
        background: linear-gradient(180deg, #0f0f0f 0%, #130e00 100%);
        padding: 48px 0 32px;
    }
    .history-content {
        background: linear-gradient(180deg, #130e00 0%, #0f0f0f 100%);
        padding: 40px 0 60px;
    }
    .badge-arena {
        background: rgba(232,93,0,0.12);
        color: #e85d00;
        border: 1px solid rgba(232,93,0,0.25);
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 12px;
        display: inline-block;
    }
    .table-history {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #0f5132;
        border-radius: 16px;
        overflow: hidden;
        background: #0f0f0f;
    }
    .table-history thead tr {
        background: linear-gradient(90deg, #b84500, #e85d00, #ff7a1a, #ff9a4a);
    }
    .table-history thead th {
        padding: 12px 16px;
        text-align: left;
        font-weight: bold;
        font-size: 13px;
        letter-spacing: 0.5px;
        color: white;
        border: 1px solid #0f5132;
        white-space: nowrap;
    }
    .table-history tbody tr:nth-child(even) { background-color: #ffffff; }
    .table-history tbody tr:nth-child(odd)  { background-color: #f2f2f2; }
    .table-history tbody tr:hover           { background-color: #ffe5d0; }
    .table-history tbody td {
        padding: 12px 16px;
        color: #1a1a1a;
        vertical-align: middle;
        font-size: 13px;
        border: 1px solid #0f5132;
    }
    .booking-code {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: #e85d00;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .badge-pending    { background: #f0f0f0; color: #666; border: 1px solid #ccc; }
    .badge-waiting    { background: #fff3e0; color: #e85d00; border: 1px solid #ffd9a5; }
    .badge-paid       { background: #e0f5e9; color: #2e7d32; border: 1px solid #b9f6ca; }
    .badge-completed  { background: #e0f5e9; color: #2e7d32; border: 1px solid #b9f6ca; }
    .badge-cancelled  { background: #ffe6e5; color: #c62828; border: 1px solid #ffcdd2; }
    .badge-failed     { background: #ffe6e5; color: #c62828; border: 1px solid #ffcdd2; }
    .btn-invoice {
        background: #ffffff;
        border: 1px solid #e85d00;
        color: #e85d00;
        border-radius: 6px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
    }
    .btn-invoice:hover {
        background: #e85d00;
        color: white;
    }
    .btn-cancel {
        background: #ffffff;
        border: 1px solid #6b7280;
        color: #6b7280;
        border-radius: 6px;
        padding: 5px 14px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-block;
        margin-top: 5px;
    }
    .btn-cancel:hover {
        background: #374151;
        border-color: #374151;
        color: white;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #777;
    }
    .pagination .page-link {
        background: #fff;
        border-color: #dee2e6;
        color: #e85d00;
    }
    .pagination .page-item.active .page-link {
        background: #e85d00;
        border-color: #e85d00;
        color: white;
    }
    .pagination .page-link:hover {
        background: #f8f9fa;
        border-color: #e85d00;
        color: #c44d00;
    }
</style>
@endpush

@section('content')

<div class="history-header">
    <div class="container text-center">
        <span class="badge-arena px-3 py-2 mb-2">Akun Saya</span>
        <h1 class="fw-bold text-white mb-1">Riwayat Booking</h1>
        <p style="color:#888; font-size:0.9rem;">Semua riwayat reservasi lapangan kamu</p>
    </div>
</div>

<div class="history-content">
    <div class="container">
        <div class="table-responsive">
            <table class="table-history">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td><span class="booking-code">{{ $booking->booking_code }}</span></td>
                        <td>{{ $booking->lapangan->name }}</td>
                        <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                        <td style="white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} –
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                        </td>
                        <td>{{ $booking->duration_hours }} jam</td>
                        <td style="font-weight:700; color:#e85d00;">Rp {{ number_format($booking->total_price) }}</td>
                        <td>
                            @if($booking->payment_status == 'pending')
                                <span class="status-badge badge-pending"><i class="fas fa-clock"></i> Menunggu Bayar</span>
                            @elseif($booking->payment_status == 'waiting_confirmation')
                                <span class="status-badge badge-waiting"><i class="fas fa-hourglass-half"></i> Menunggu Verifikasi</span>
                            @elseif($booking->payment_status == 'paid')
                                <span class="status-badge badge-paid"><i class="fas fa-check"></i> Lunas</span>
                            @elseif($booking->payment_status == 'completed')
                                <span class="status-badge badge-completed"><i class="fas fa-flag-checkered"></i> Selesai</span>
                            @elseif($booking->payment_status == 'cancelled')
                                <span class="status-badge badge-cancelled"><i class="fas fa-times"></i> Dibatalkan</span>
                            @elseif($booking->payment_status == 'failed')
                                <span class="status-badge badge-failed"><i class="fas fa-times-circle"></i> Gagal</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('booking.invoice', $booking->id) }}" class="btn-invoice">
                                <i class="fas fa-file-invoice me-1"></i> Invoice
                            </a>
                            @if(in_array($booking->payment_status, ['pending', 'waiting_confirmation']) && $booking->payment_method == 'cash')
                                <form action="{{ route('bookings.cancelByUser', $booking->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                    @csrf
                                    <button type="submit" class="btn-cancel">
                                        <i class="fas fa-ban me-1"></i> Batalkan
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-calendar-times" style="font-size:3rem; color:#e85d00; display:block; margin-bottom:16px;"></i>
                                <div style="font-weight:600;">Belum ada booking</div>
                                <div style="font-size:12px; margin-top:4px;">Yuk reservasi lapangan sekarang!</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>

@endsection