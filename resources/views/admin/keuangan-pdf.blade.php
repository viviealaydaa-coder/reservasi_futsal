<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - KickIn</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 32px;
            color: #1A1A1A;
            background: #fff;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            table-layout: fixed;
        }
        th {
            background: #E85D00;
            color: white;
            font-weight: 500;
            padding: 10px 12px;
            text-align: left;
        }
        th:last-child { text-align: right; }
        td {
            padding: 9px 12px;
            color: #1A1A1A;
            border-bottom: 0.5px solid #E5E7EB;
            vertical-align: middle;
        }
        td:last-child { text-align: right; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <table style="width:100%; border-collapse:collapse; margin-bottom:14px;">
        <tr>
            <td style="border:none; padding:0; vertical-align:top;">
                <div style="font-size:20px; font-weight:700; color:#E85D00; margin-bottom:4px;">Laporan Keuangan KickIn</div>
                <div style="font-size:12px; color:#555;">
                    Periode: {{ date('d/m/Y', strtotime($startDate)) }} – {{ date('d/m/Y', strtotime($endDate)) }}
                    @if($status) &nbsp;| Metode: {{ strtoupper($status) }} @endif
                </div>
            </td>
            <td style="border:none; padding:0; text-align:right; vertical-align:top; font-size:11px; color:#888; line-height:1.8;">
                Dicetak oleh: {{ auth()->user()->name }}<br>
                {{ now()->format('d/m/Y, H:i') }} WIB<br>
                KickIn Futsal · Palembang
            </td>
        </tr>
    </table>
    <div style="border-bottom:2px solid #E85D00; margin-bottom:20px;"></div>

    {{-- STATS --}}
    @php
        $totalCash = $transactions->where('payment_method', 'cash')->sum('total_price');
        $totalQris = $transactions->where('payment_method', 'qris')->sum('total_price');
    @endphp

    <table style="width:100%; border-collapse:separate; border-spacing:10px 0; margin-bottom:24px;">
        <tr>
            <td style="background:#F3F4F6; border-radius:8px; padding:14px 16px; width:25%; border:none;">
                <div style="font-size:11px; color:#6B7280; margin-bottom:6px;">Total Pendapatan</div>
                <div style="font-size:16px; font-weight:700; color:#1A1A1A;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </td>
            <td style="background:#F3F4F6; border-radius:8px; padding:14px 16px; width:25%; border:none;">
                <div style="font-size:11px; color:#6B7280; margin-bottom:6px;">Jumlah Transaksi</div>
                <div style="font-size:16px; font-weight:700; color:#1A1A1A;">{{ $transactions->count() }}</div>
            </td>
            <td style="background:#F3F4F6; border-radius:8px; padding:14px 16px; width:25%; border:none;">
                <div style="font-size:11px; color:#6B7280; margin-bottom:6px;">Via Cash</div>
                <div style="font-size:16px; font-weight:700; color:#1A1A1A;">Rp {{ number_format($totalCash, 0, ',', '.') }}</div>
            </td>
            <td style="background:#F3F4F6; border-radius:8px; padding:14px 16px; width:25%; border:none;">
                <div style="font-size:11px; color:#6B7280; margin-bottom:6px;">Via QRIS</div>
                <div style="font-size:16px; font-weight:700; color:#1A1A1A;">Rp {{ number_format($totalQris, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    {{-- TABEL TRANSAKSI --}}
    <table>
        <thead>
            <tr>
                <th style="width:16%">Tanggal</th>
                <th style="width:22%">Kode Booking</th>
                <th style="width:13%">Penyewa</th>
                <th style="width:15%">Lapangan</th>
                <th style="width:10%">Durasi</th>
                <th style="width:10%">Metode</th>
                <th style="width:14%">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td style="font-size:10px; color:#6B7280;">{{ $t->booking_code }}</td>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->lapangan->name }}</td>
                <td>{{ $t->duration_hours }} jam</td>
                <td>{{ strtoupper($t->payment_method) }}</td>
                <td>{{ number_format($t->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#9CA3AF; padding:20px;">
                    Tidak ada transaksi dalam periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div style="text-align:right; font-size:12px; margin-top:10px; padding-top:10px; border-top:0.5px solid #E5E7EB;">
        Total Pendapatan &nbsp;
        <span style="font-size:13px; font-weight:700; color:#E85D00;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
    </div>

   {{-- FOOTER --}}
    <div style="margin-top:24px; padding-top:12px; border-top:0.5px solid #E5E7EB;">

        <table style="width:100%; border-collapse:collapse; margin-top:40px;">
            <tr>
                <td style="border:none; padding:0; vertical-align:bottom;"></td>
                <td style="border:none; text-align:center; width:200px; vertical-align:bottom; padding:0;">
                    <div style="font-size:11px; color:#6B7280; margin-bottom:4px;">Palembang, {{ now()->format('d/m/Y') }}</div>
                    <div style="font-size:11px; color:#6B7280; margin-bottom:70px;">Admin KickIn,</div>
                    <div style="padding-top:6px; font-size:11px; color:#6B7280; white-space:nowrap;">                        (
                        <span style="display:inline-block; width:140px;"></span>
                        )
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>