@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* -------------------------------------------------------------
       BACKGROUND UTAMA (abu-abu gelap, bukan hitam pekat)
    ------------------------------------------------------------- */
    body {
        background: #121212 !important;
    }

    /* -------------------------------------------------------------
       STATISTIK – latar abu medium, angka oranye, label putih
    ------------------------------------------------------------- */
    .stats-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 32px;
        border-radius: 20px;
        overflow: hidden;
        gap: 0;
        background: transparent;
    }
    .stat-item {
        flex: 1;
        min-width: 150px;
        padding: 24px 16px;
        text-align: center;
        background: #252525;          /* abu medium, tidak terlalu terang */
        margin-right: 1px;
        transition: all 0.2s;
    }
    .stat-item:last-child {
        margin-right: 0;
    }
    .stat-item:hover {
        background: #2f2f2f;
        transform: translateY(-2px);
    }
    .stat-number {
        font-size: 34px;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 8px;
        color: #e85d00;               /* oranye khas */
        font-family: 'Montserrat', sans-serif;
    }
    .stat-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #c0c0c0;               /* putih keabuan */
    }

    /* -------------------------------------------------------------
       PANEL UTAMA (lapangan aktif, verifikasi terbaru, dll)
    ------------------------------------------------------------- */
    .dashboard-panel {
        background: #1e1e1e;           /* abu gelap */
        border: 1px solid #2c2c2c;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 24px;
    }
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #f0f0f0;
        margin-bottom: 4px;
    }
    .section-subtitle {
        font-size: 12px;
        color: #888;
        margin-bottom: 16px;
        border-left: 3px solid #e85d00;
        padding-left: 10px;
    }

    /* -------------------------------------------------------------
       TABEL (tetap pakai .table-arena, seragam dengan halaman lain)
    ------------------------------------------------------------- */
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

    /* -------------------------------------------------------------
       BADGE STATUS (sama seperti halaman booking)
    ------------------------------------------------------------- */
    .status-badge-sm {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        text-align: center;
        min-width: 100px;
    }
    .badge-waiting { background: #f97316; color: #000; }
    .badge-paid    { background: #22c55e; color: #000; }
    .badge-danger  { background: #ef4444; color: #fff; }

    /* -------------------------------------------------------------
       KOMPONEN KECIL (booking time, tombol, link invoice, dll)
    ------------------------------------------------------------- */
    .booking-time {
        font-family: monospace;
        font-size: 12px;
        background: #e8e8e8;
        padding: 2px 6px;
        border-radius: 6px;
        white-space: nowrap;
        color: #333;
    }
    .btn-verify-small {
        background: #e85d00;
        border: none;
        border-radius: 6px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-verify-small:hover {
        background: #c44d00;
    }
    .invoice-link {
        display: inline-block;
        background: rgba(232,93,0,0.15);
        color: #e85d00;
        border: 1px solid rgba(232,93,0,0.3);
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 11px;
        text-decoration: none;
        transition: 0.2s;
    }
    .invoice-link:hover {
        background: #e85d00;
        color: white;
    }
    .active-lapangan-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background: #2a2a2a;
        border: 1px solid #3a3a3a;
        border-radius: 12px;
        margin-bottom: 8px;
    }
    .active-lapangan-item:hover {
        border-color: #e85d00;
    }
    .lapangan-name {
        font-weight: 600;
        color: #e0e0e0;
    }
    .lapangan-type {
        font-size: 11px;
        background: rgba(232,93,0,0.2);
        padding: 2px 8px;
        border-radius: 20px;
        color: #e85d00;
    }
    .btn-sm-link {
        font-size: 12px;
        color: #e85d00;
        text-decoration: none;
    }

    /* -------------------------------------------------------------
       RIWAYAT VERIFIKASI (list item, background gelap)
    ------------------------------------------------------------- */
    .verif-item {
        border-bottom: 1px solid #2a2a2a;
        padding: 12px 0;
    }
    .verif-item:last-child {
        border-bottom: none;
    }
    .alert-pending {
        background: rgba(232,93,0,0.12);
        border: 1px solid rgba(232,93,0,0.3);
        border-radius: 30px;
        padding: 8px 16px;
        color: #e85d00;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-laporan {
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
    .btn-laporan:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        color: white;
    }
    .modal-booking {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        background: #1e1e1e;
        border-radius: 16px;
        max-width: 500px;
        width: 90%;
        max-height: 90%;
        overflow: auto;
        padding: 20px;
        border: 1px solid #333;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #888;
    }
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 8px;
        display: block;
        color: #e85d00;
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    {{-- HEADER dashboard --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 style="font-family: 'Montserrat', sans-serif; font-weight: 800; color: #f0f0f0; margin: 0;">
                Dashboard Admin
            </h2>
            <p style="font-size: 13px; color: #aaa; margin-top: 4px;">
                {{ now()->translatedFormat('l, d F Y') }} — Kelola dan pantau operasional lapangan
            </p>
        </div>
        <div class="d-flex gap-2">
            {{-- Tombol ke laporan keuangan (sudah ada) --}}
            <a href="{{ route('laporan.keuangan') }}" class="btn-laporan">
                <i class="fas fa-chart-line"></i> Laporan Keuangan
            </a>
            @if($pendingVerification > 0)
                <a href="{{ route('admin.bookings.index') }}?status=waiting_confirmation" class="alert-pending">
                    <i class="fas fa-exclamation-circle"></i> {{ $pendingVerification }} menunggu verifikasi
                </a>
            @endif
        </div>
    </div>

    {{-- 4 kotak statistik --}}
    <div class="stats-row">
        <div class="stat-item">
            <div class="stat-number">{{ $todayBookings->count() }}</div>
            <div class="stat-label">Booking Hari Ini</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $needVerificationBookings->count() }}</div>
            <div class="stat-label">Perlu Verifikasi</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ \App\Models\Lapangan::where('is_active', true)->count() }}</div>
            <div class="stat-label">Lapangan Aktif</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $recentVerified->count() }}</div>
            <div class="stat-label">Verifikasi Terbaru</div>
        </div>
    </div>

    {{-- TABEL 1: SEGERA VERIFIKASI --}}
    <div class="dashboard-panel">
        <div class="section-title">
            <i class="fas fa-clock me-2" style="color:#e85d00;"></i> Segera Verifikasi
        </div>
        <div class="section-subtitle">Booking yang belum diverifikasi (paling lama menunggu)</div>

        @if($needVerificationBookings->count() > 0)
            <div class="table-responsive">
                <table class="table-arena">
                    <thead>
                        <tr>
                            <th>Waktu Booking</th>
                            <th>Kode</th>
                            <th>Pemesan</th>
                            <th>Lapangan</th>
                            <th>Tgl & Jam</th>
                            <th>Metode</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($needVerificationBookings as $booking)
                        <tr>
                            <td>{{ $booking->created_at->format('H:i, d/m') }}</td>
                            <td><span style="font-family: monospace; font-weight: 600; color:#e85d00;">{{ $booking->booking_code }}</span></td>
                            <td>{{ $booking->user->name }}<br><span style="font-size:11px; color:#aaa;">{{ $booking->user->phone }}</span></td>
                            <td>{{ $booking->lapangan->name }}</td>
                            <td>
                                {{ $booking->booking_date->format('d/m/Y') }}<br>
                                <span class="booking-time">{{ $booking->start_time }} ({{ $booking->duration_hours }} jam)</span>
                            </td>
                            <td>
                                @if($booking->payment_method == 'qris')
                                    <span style="background:rgba(232,93,0,0.15); padding:2px 8px; border-radius:20px; font-size:11px;">QRIS</span>
                                @elseif($booking->payment_method == 'transfer')
                                    <span style="background:rgba(59,130,246,0.15); padding:2px 8px; border-radius:20px; font-size:11px;">Transfer</span>
                                @else
                                    {{ $booking->payment_method }}
                                @endif
                            </td>
                            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td>
                                <button type="button" class="btn-verify-small btn-detail"
                                        data-booking="{{ $booking->toJson() }}"
                                        data-bukti="{{ $booking->payment_proof ? asset('storage/' . $booking->payment_proof) : '' }}"
                                        data-verify-route="{{ route('admin.booking.verify', $booking->id) }}"
                                        data-reject-route="{{ route('admin.booking.reject', $booking->id) }}">
                                    <i class="fas fa-eye"></i> Detail & Bukti
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                <span>Tidak ada booking yang perlu verifikasi.</span>
            </div>
        @endif
    </div>

    {{-- TABEL 2: JADWAL BOOKING HARI INI --}}
    <div class="dashboard-panel">
        <div class="section-title">
            <i class="fas fa-calendar-day me-2" style="color:#3b82f6;"></i> Jadwal Booking Hari Ini
        </div>
        <div class="section-subtitle">Booking yang sudah terkonfirmasi (paid) dan selesai</div>

        @if($todayBookings->count() > 0)
            <div class="table-responsive">
                <table class="table-arena">
                    <thead>
                        <tr>
                            <th>Jam Main</th>
                            <th>Lapangan</th>
                            <th>Pemesan</th>
                            <th>Kode Booking</th>
                            <th>Status</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todayBookings as $booking)
                        <tr>
                            <td><span class="booking-time">{{ $booking->start_time }} - {{ $booking->end_time }}</span></td>
                            <td>{{ $booking->lapangan->name }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td><span style="font-family: monospace; font-weight: 600; color:#e85d00;">{{ $booking->booking_code }}</span></td>
                            <td>
                                @if($booking->payment_status == 'paid')
                                    <span class="status-badge-sm badge-paid"><i class="fas fa-check-circle"></i> Lunas</span>
                                @elseif($booking->payment_status == 'completed')
                                    <span class="status-badge-sm badge-paid"><i class="fas fa-flag-checkered"></i> Selesai</span>
                                @elseif($booking->payment_status == 'waiting_confirmation')
                                    <span class="status-badge-sm badge-waiting">Menunggu Verif</span>
                                @else
                                    <span class="status-badge-sm badge-danger">{{ $booking->payment_status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('booking.invoice', $booking->id) }}" target="_blank" class="invoice-link">
                                    <i class="fas fa-receipt"></i> Invoice
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <span>Tidak ada booking untuk hari ini.</span>
            </div>
        @endif
    </div>

    {{-- DUA KOLOM BAWAH: lapangan aktif + riwayat verifikasi --}}
    <div class="row g-3">
        <div class="col-md-6">
            <div class="dashboard-panel" style="height: 100%;">
                <div class="section-title">
                    <i class="fas fa-futbol me-2" style="color:#22c55e;"></i> Lapangan Aktif
                </div>
                <div class="section-subtitle">Daftar lapangan yang sedang tersedia</div>

                @php
                    $activeLapangansList = \App\Models\Lapangan::where('is_active', true)->orderBy('name')->get();
                @endphp
                @if($activeLapangansList->count() > 0)
                    @foreach($activeLapangansList as $lap)
                        <div class="active-lapangan-item">
                            <div>
                                <span class="lapangan-name">{{ $lap->name }}</span>
                                <span class="lapangan-type">{{ ucfirst($lap->type) }}</span>
                            </div>
                            <a href="{{ route('admin.lapangans.edit', $lap->id) }}" class="btn-sm-link">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle" style="color:#ef4444;"></i>
                        <span>Tidak ada lapangan aktif.</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-panel" style="height: 100%;">
                <div class="section-title">
                    <i class="fas fa-history me-2" style="color:#8b5cf6;"></i> Verifikasi Terbaru
                </div>
                <div class="section-subtitle">Admin yang baru saja memverifikasi booking</div>

                @if($recentVerified->count() > 0)
                    @foreach($recentVerified as $verif)
                        <div class="verif-item">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-family: monospace; font-weight: 700; color:#e85d00;">{{ $verif->booking_code }}</span>
                                <span style="font-size: 11px; color: #aaa;">{{ $verif->payment_verified_at->diffForHumans() }}</span>
                            </div>
                            <div style="font-size: 13px; color:#d0d0d0; margin-top: 4px;">{{ $verif->lapangan->name }} · {{ $verif->user->name }}</div>
                            <div style="font-size: 11px; color:#e85d00; margin-top: 2px;">
                                <i class="fas fa-user-check"></i> Diverifikasi oleh: {{ $verif->verifier->name ?? 'System' }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-info-circle"></i>
                        <span>Belum ada verifikasi.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL BUKTI (sama persis seperti halaman booking) --}}
<div id="modalDetail" class="modal-booking">
    <div class="modal-content">
        <div style="display:flex; justify-content:space-between; margin-bottom:16px;">
            <h4 style="margin:0; color:#e85d00;">Detail Booking & Bukti</h4>
            <button id="closeModal" style="background:none; border:none; color:#aaa; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <div id="modalContent"></div>
        <div id="modalActions" style="display:flex; gap:10px; margin-top:20px; justify-content:flex-end;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('modalDetail');
    const modalContent = document.getElementById('modalContent');
    const modalActions = document.getElementById('modalActions');
    const closeModal = document.getElementById('closeModal');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Fungsi buka modal, isi data booking + bukti
    function openModal(booking, buktiUrl, verifyRoute, rejectRoute) {
        let html = `
            <div style="margin-bottom:12px;"><strong>Kode Booking:</strong> ${booking.booking_code}</div>
            <div style="margin-bottom:12px;"><strong>Pemesan:</strong> ${booking.user.name} (${booking.user.phone})</div>
            <div style="margin-bottom:12px;"><strong>Lapangan:</strong> ${booking.lapangan.name}</div>
            <div style="margin-bottom:12px;"><strong>Tanggal Main:</strong> ${booking.booking_date} ${booking.start_time} (${booking.duration_hours} jam)</div>
            <div style="margin-bottom:12px;"><strong>Total Bayar:</strong> Rp ${new Intl.NumberFormat('id-ID').format(booking.total_price)}</div>
            <div style="margin-bottom:12px;"><strong>Metode:</strong> ${booking.payment_method?.toUpperCase() || '-'}</div>
            <div style="margin-bottom:16px;"><strong>Bukti Pembayaran:</strong></div>
        `;
        if (buktiUrl) {
            html += `<div><img src="${buktiUrl}" style="max-width:100%; border-radius:8px; border:1px solid #333;"></div>`;
        } else {
            html += `<div style="color:#777; padding:12px; background:#2a2a2a; border-radius:8px;">Tidak ada bukti pembayaran (mungkin metode cash atau belum upload).</div>`;
        }
        modalContent.innerHTML = html;

        modalActions.innerHTML = `
            <form method="POST" action="${verifyRoute}" style="display:inline-block;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" style="background:#22c55e; border:none; padding:8px 16px; border-radius:8px; color:white; cursor:pointer;">✓ Verifikasi</button>
            </form>
            <form method="POST" action="${rejectRoute}" style="display:inline-block;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" style="background:#ef4444; border:none; padding:8px 16px; border-radius:8px; color:white; cursor:pointer;" onclick="return confirm('Yakin tolak pembayaran ini?')">✗ Tolak</button>
            </form>
        `;
        modal.style.display = 'flex';
    }

    // Pasang event listener ke semua tombol .btn-detail
    document.querySelectorAll('.btn-detail').forEach(btn => {
        btn.addEventListener('click', function() {
            const booking = JSON.parse(this.dataset.booking);
            const buktiUrl = this.dataset.bukti;
            const verifyRoute = this.dataset.verifyRoute;
            const rejectRoute = this.dataset.rejectRoute;
            openModal(booking, buktiUrl, verifyRoute, rejectRoute);
        });
    });

    closeModal.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });
</script>
@endpush