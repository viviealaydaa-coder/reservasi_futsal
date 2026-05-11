@extends('layouts.app')

@section('title', 'Kelola Booking')

@push('styles')
<style>
    .booking-header {
        background: linear-gradient(180deg, #0f0f0f 0%, #130e00 100%);
        padding: 48px 0 32px;
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
    .booking-content {
        background: linear-gradient(180deg, #130e00 0%, #0f0f0f 100%);
        padding: 40px 0 60px;
    }
    .filter-card {
        background: linear-gradient(145deg, #1c1c1c, #161616);
        border: 1px solid #272727;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 30px;
        transition: 0.2s;
    }
    .filter-card:hover {
        border-color: #e85d00;
        box-shadow: 0 4px 12px rgba(232,93,0,0.1);
    }
    .filter-card .form-control, 
    .filter-card .form-select {
        background: #161616;
        border-color: #2a2a2a;
        color: #d0d0d0;
        border-radius: 12px;
    }
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        background: #1a1a1a;
        border-color: #e85d00;
        box-shadow: 0 0 0 3px rgba(232,93,0,0.15);
    }
    .btn-custom-search {
        background: linear-gradient(135deg, #e85d00, #ff7a1a);
        border: none;
        color: white;
        border-radius: 12px;
        padding: 9px 20px;
        font-weight: 600;
        transition: 0.2s;
    }
    .btn-custom-search:hover {
        background: linear-gradient(135deg, #c44d00, #e85d00);
        transform: translateY(-2px);
    }
    .table-booking {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #0f5132;
        border-radius: 16px;
        overflow: hidden;
        background: #0f0f0f;
    }
    .table-booking thead tr {
        background: linear-gradient(90deg, #b84500, #e85d00, #ff7a1a, #ff9a4a);
    }
    .table-booking thead th {
        padding: 12px 16px;
        text-align: left;
        font-weight: bold;
        font-size: 13px;
        letter-spacing: 0.5px;
        color: white;
        border: 1px solid #0f5132;
        white-space: nowrap;
    }
    .table-booking tbody tr:nth-child(even) {
        background-color: #ffffff;
    }
    .table-booking tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }
    .table-booking tbody tr:hover {
        background-color: #ffe5d0;
    }
    .table-booking tbody td {
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
    .user-name {
        font-weight: 600;
        color: #1a1a1a;
    }
    .user-phone {
        font-size: 11px;
        color: #555;
        margin-top: 2px;
    }
    .price-cell {
        font-weight: 700;
        color: #e85d00;
        font-size: 13px;
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
    .badge-pending {
        background: #f0f0f0;
        color: #666;
        border: 1px solid #ccc;
    }
    .badge-waiting {
        background: #fff3e0;
        color: #e85d00;
        border: 1px solid #ffd9a5;
    }
    .badge-paid {
        background: #e0f5e9;
        color: #2e7d32;
        border: 1px solid #b9f6ca;
    }
    .badge-completed {
        background: #e0f5e9;
        color: #2e7d32;
        border: 1px solid #b9f6ca;
    }
    .badge-cancelled {
        background: #ffe6e5;
        color: #c62828;
        border: 1px solid #ffcdd2;
    }
    .action-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 130px;
    }
    .btn-action {
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        transition: all 0.2s;
        cursor: pointer;
        border: 1px solid transparent;
        background: transparent;
    }
    .btn-verify {
        background: #ffffff;
        border-color: #e85d00;
        color: #e85d00;
    }
    .btn-verify:hover {
        background: #e85d00;
        color: white;
        transform: translateY(-1px);
    }
    .btn-reject {
        background: #ffffff;
        border-color: #ef4444;
        color: #ef4444;
    }
    .btn-reject:hover {
        background: #ef4444;
        color: white;
    }
    .btn-complete {
        background: #ffffff;
        border-color: #e85d00;
        color: #e85d00;
    }
    .btn-complete:hover {
        background: #e85d00;
        color: white;
    }
    .btn-cancel {
        background: #ffffff;
        border-color: #6b7280;
        color: #6b7280;
    }
    .btn-cancel:hover {
        background: #374151;
        border-color: #374151;
        color: white;
    }
    .btn-proof {
        background: #ffffff;
        border-color: #0ea5e9;
        color: #0ea5e9;
        text-decoration: none;
        display: block;
        text-align: center;
    }
    .btn-proof:hover {
        background: #0ea5e9;
        color: white;
    }
    .complete-inline .form-control {
        background: #f9f9f9;
        border: 1px solid #ccc;
        color: #1a1a1a;
        border-radius: 6px;
        font-size: 12px;
        padding: 5px 10px;
        margin-bottom: 5px;
    }
    .complete-inline .form-control:focus {
        border-color: #e85d00;
        box-shadow: 0 0 0 2px rgba(232,93,0,0.2);
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #777;
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        display: block;
        color: #e85d00;
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
<div class="booking-header">
    <div class="container text-center">
        <span class="badge-arena px-3 py-2 mb-2">Admin Panel</span>
        <h1 class="fw-bold text-white mb-1">Kelola Booking</h1>
        <p class="text-muted" style="color:#888 !important; font-size:0.9rem;">Verifikasi, konfirmasi, dan kelola semua reservasi</p>
    </div>
</div>

<div class="booking-content">
    <div class="container">
        <div class="filter-card">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label text-muted small">Filter Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="waiting_confirmation" {{ request('status')=='waiting_confirmation' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="paid" {{ request('status')=='paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label text-muted small">Cari Booking</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama pemesan / kode booking" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button class="btn-custom-search w-100" type="submit">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-booking">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pemesan</th>
                        <th>Lapangan</th>
                        <th>Tanggal / Jam</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td><span class="booking-code">{{ $booking->booking_code }}</span></td>
                        <td>
                            <div class="user-name">{{ $booking->user->name }}</div>
                            <div class="user-phone">{{ $booking->user->phone }}</div>
                        </td>
                        <td>{{ $booking->lapangan->name }}</td>
                        <td style="white-space: nowrap;">
                            {{ $booking->booking_date->format('d/m/Y') }}<br>
                            <span style="font-size: 11px; color: #555;">{{ $booking->start_time }}</span>
                        </td>
                        <td class="price-cell">Rp {{ number_format($booking->total_price) }}</td>
                        <td>{{ strtoupper($booking->payment_method) }}</td>
                        <td>
                            @if($booking->payment_status == 'pending')
                                <span class="status-badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                            @elseif($booking->payment_status == 'waiting_confirmation')
                                <span class="status-badge badge-waiting"><i class="fas fa-hourglass-half"></i> Menunggu Verif</span>
                            @elseif($booking->payment_status == 'paid')
                                <span class="status-badge badge-paid"><i class="fas fa-check"></i> Lunas</span>
                            @elseif($booking->payment_status == 'completed')
                                <span class="status-badge badge-completed"><i class="fas fa-flag-checkered"></i> Selesai</span>
                            @elseif($booking->payment_status == 'cancelled')
                                <span class="status-badge badge-cancelled"><i class="fas fa-times"></i> Dibatalkan</span>
                            @else
                                <span class="status-badge badge-pending">{{ $booking->payment_status }}</span>
                            @endif
                         </td>
                        <td>
                            <div class="action-group">
                                @if($booking->payment_status == 'waiting_confirmation')
                                    <form action="{{ route('admin.booking.verify', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action btn-verify w-100"><i class="fas fa-check-circle me-1"></i> Verifikasi</button>
                                    </form>
                                    <form action="{{ route('admin.booking.reject', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action btn-reject w-100"><i class="fas fa-times-circle me-1"></i> Tolak</button>
                                    </form>
                                @endif
                                @if($booking->payment_status == 'paid')
                                    <form action="{{ route('admin.booking.complete', $booking->id) }}" method="POST">
                                        @csrf
                                        <div class="complete-inline">
                                            <input type="text" name="damage_notes" placeholder="Catatan kerusakan" class="form-control">
                                            <input type="number" name="damage_fee" placeholder="Denda (Rp)" class="form-control">
                                        </div>
                                        <button type="submit" class="btn-action btn-complete w-100 mt-1"><i class="fas fa-flag-checkered me-1"></i> Tandai Selesai</button>
                                    </form>
                                @endif
                                @if(in_array($booking->payment_status, ['pending','waiting_confirmation']))
                                    <form action="{{ route('admin.booking.cancel', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action btn-cancel w-100"><i class="fas fa-ban me-1"></i> Batalkan</button>
                                    </form>
                                @endif
                                @if($booking->payment_proof)
                                    <a href="{{ asset('storage/'.$booking->payment_proof) }}" target="_blank" class="btn-action btn-proof w-100"><i class="fas fa-image me-1"></i> Lihat Bukti</a>
                                @endif
                                <a href="{{ route('booking.invoice', $booking->id) }}" target="_blank" class="btn-action btn-proof w-100">
                                    <i class="fas fa-file-invoice me-1"></i> Invoice
                                </a>
                            </div>
                         </td>
                     </tr>
                    @empty
                     <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <div style="font-weight: 600;">Tidak ada booking ditemukan</div>
                                <div style="font-size: 12px; margin-top: 4px;">Coba ubah filter atau kata kunci pencarian</div>
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