@extends('layouts.app')

@section('title', 'Booking Lapangan — KickIn')

@section('content')

<div style="background:#0f0f0f; min-height:100vh; padding:40px 0 80px;">
    <div class="container">

        @php
            $openingTime = !empty($lapangan->opening_time)
                ? \Carbon\Carbon::parse($lapangan->opening_time)->format('g:i A')
                : '-';

            $closingTime = !empty($lapangan->closing_time)
                ? \Carbon\Carbon::parse($lapangan->closing_time)->format('g:i A')
                : '-';
        @endphp

        {{-- HEADER --}}
        <div style="text-align:center; margin-bottom:36px;">
            <span style="font-size:0.7rem; font-weight:700; letter-spacing:2px; color:#e85d00; text-transform:uppercase;">
                Form Booking
            </span>

            <h1 style="color:#ffffff; font-family:'Montserrat',sans-serif; font-weight:900; font-size:clamp(1.6rem,4vw,2.2rem); margin:8px 0 0;">
                {{ $lapangan->name }}
            </h1>

            <p style="color:#666; font-size:0.88rem; margin-top:6px;">
                {{ $lapangan->type == 'indoor' ? 'Indoor' : 'Outdoor' }}
                &nbsp;·&nbsp;
                {{ $openingTime }} – {{ $closingTime }}
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            {{-- FORM KIRI --}}
            <div class="col-lg-7">
                <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
                    @csrf

                    <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

                    {{-- SECTION: Detail Booking --}}
                    <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:28px; margin-bottom:20px;">

                        <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:20px;">
                            Detail Booking
                        </div>

                        {{-- Tanggal --}}
                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:0.78rem; font-weight:600; color:#aaa; letter-spacing:0.5px; margin-bottom:8px; text-transform:uppercase;">
                                Tanggal Sewa
                            </label>

                            <input type="date"
                                name="booking_date"
                                id="booking_date"
                                min="{{ date('Y-m-d') }}"
                                max="{{ $maxDate->format('Y-m-d') }}"
                                required
                                style="width:100%; background:#1a1a1a; border:1px solid #2a2a2a; border-radius:10px;
                                color:#fff; padding:12px 16px; font-size:0.92rem; outline:none;
                                transition:border 0.2s; color-scheme:dark;"
                                onfocus="this.style.border='1px solid rgba(232,93,0,0.5)'"
                                onblur="this.style.border='1px solid #2a2a2a'">
                        </div>

                        {{-- Jam Mulai --}}
                        <div style="margin-bottom:20px;">

                            <label style="display:block; font-size:0.78rem; font-weight:600; color:#aaa; letter-spacing:0.5px; margin-bottom:8px; text-transform:uppercase;">
                                Jam Mulai
                            </label>

                            <select name="start_time"
                                id="start_time"
                                required
                                style="width:100%; background:#1a1a1a; border:1px solid #2a2a2a; border-radius:10px;
                                color:#fff; padding:12px 16px; font-size:0.92rem; outline:none;
                                transition:border 0.2s; appearance:none; cursor:pointer;"
                                onfocus="this.style.border='1px solid rgba(232,93,0,0.5)'"
                                onblur="this.style.border='1px solid #2a2a2a'">

                                <option value="">-- Pilih Jam Mulai --</option>

                                @php
                                    $start = strtotime($lapangan->opening_time);
                                    $end = strtotime($lapangan->closing_time);

                                    while ($start <= $end) {
                                        $time = date('H:i', $start);
                                        echo "<option value='{$time}'>{$time}</option>";
                                        $start = strtotime('+1 hour', $start);
                                    }
                                @endphp

                            </select>

                            <div id="slotError"
                                style="color:#ff6b6b; font-size:0.75rem; margin-top:5px; display:none;">
                            </div>

                        </div>

                        {{-- Durasi --}}
                        <div>

                            <label style="display:block; font-size:0.78rem; font-weight:600; color:#aaa; letter-spacing:0.5px; margin-bottom:10px; text-transform:uppercase;">
                                Durasi Sewa
                                <span style="color:#555; font-weight:400; text-transform:none;">
                                    (minimal 2 jam)
                                </span>
                            </label>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">

                                @foreach([
                                    [2, $lapangan->price_2jam],
                                    [3, $lapangan->price_3jam],
                                    [4, $lapangan->price_4jam],
                                    [5, $lapangan->price_5jam],
                                ] as [$jam, $harga])

                                    <label id="dur-lbl-{{ $jam }}"
                                        style="display:flex; flex-direction:column; align-items:center; justify-content:center;
                                        background:#1a1a1a; border:1px solid #2a2a2a; border-radius:10px;
                                        padding:14px 10px; cursor:pointer; transition:all 0.2s; text-align:center;">

                                        <input type="radio"
                                            name="duration_hours"
                                            value="{{ $jam }}"
                                            {{ request('duration') == $jam || ($jam == 2 && !request('duration')) ? 'checked' : '' }}
                                            style="display:none;"
                                            onchange="updateDurasi({{ $jam }})">

                                        <span class="dur-jam"
                                            style="font-size:1.1rem; font-weight:800; color:#fff; font-family:'Montserrat',sans-serif;">
                                            {{ $jam }} Jam
                                        </span>

                                        <span style="font-size:0.75rem; color:#888; margin-top:3px;">
                                            Rp {{ number_format($harga) }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>
                        </div>

                    </div>

                    {{-- SECTION: Metode Pembayaran --}}
                    <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:28px; margin-bottom:20px;">

                        <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:20px;">
                            Metode Pembayaran
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">

                            {{-- CASH --}}
                            <label id="pay-lbl-cash"
                                style="display:flex; align-items:center; gap:12px;
                                background:#1a1a1a; border:1px solid #2a2a2a;
                                border-radius:10px; padding:16px; cursor:pointer; transition:all 0.2s;">

                                <input type="radio"
                                    name="payment_method"
                                    value="cash"
                                    checked
                                    style="display:none;"
                                    onchange="updatePayment('cash')">

                                <div>
                                    <div style="font-weight:700; color:#fff; font-size:0.9rem;">
                                        Cash
                                    </div>

                                    <div style="font-size:0.7rem; color:#666; margin-top:2px;">
                                        Bayar di tempat
                                    </div>
                                </div>

                            </label>

                            {{-- QRIS --}}
                            <label id="pay-lbl-qris"
                                style="display:flex; align-items:center; gap:12px;
                                background:#1a1a1a; border:1px solid #2a2a2a;
                                border-radius:10px; padding:16px; cursor:pointer; transition:all 0.2s;">

                                <input type="radio"
                                    name="payment_method"
                                    value="qris"
                                    style="display:none;"
                                    onchange="updatePayment('qris')">

                                <div>
                                    <div style="font-weight:700; color:#fff; font-size:0.9rem;">
                                        QRIS
                                    </div>

                                    <div style="font-size:0.7rem; color:#666; margin-top:2px;">
                                        Transfer & upload bukti
                                    </div>
                                </div>

                            </label>

                        </div>

                        {{-- QRIS SECTION --}}
                        <div id="qrisSection" style="display:none;">

                            <div style="height:1px; background:#222; margin-bottom:20px;"></div>

                            <div style="text-align:center; margin-bottom:20px;">

                                <div style="font-size:0.72rem; font-weight:700; letter-spacing:1px; color:#e85d00; text-transform:uppercase; margin-bottom:12px;">
                                    Scan QRIS untuk Bayar
                                </div>

                                <div style="display:inline-block; background:#fff; border-radius:16px; padding:16px;">
                                    <img src="{{ asset('images/qris.jpg') }}"
                                        alt="QRIS"
                                        style="width:200px; height:200px; object-fit:contain; display:block;">
                                </div>

                            </div>

                            <input type="file"
                                name="payment_proof"
                                id="proofInput"
                                accept="image/*"
                                style="width:100%; background:#1a1a1a; color:#fff; border:1px solid #333;
                                border-radius:10px; padding:12px;">

                        </div>

                        {{-- CASH INFO --}}
                        <div id="cashInfo">

                            <div style="height:1px; background:#222; margin-bottom:16px;"></div>

                            <div style="background:rgba(232,93,0,0.05);
                                border:1px solid rgba(232,93,0,0.15);
                                border-radius:10px;
                                padding:14px;
                                color:#999;
                                font-size:0.82rem;
                                line-height:1.6;">

                                Booking akan divalidasi oleh admin.
                                Pastikan hadir tepat waktu dan lunasi pembayaran sebelum bermain.

                            </div>

                        </div>

                    </div>

                    {{-- SUBMIT --}}
                    <button type="submit"
                        id="submitBtn"
                        style="width:100%; background:linear-gradient(135deg, #e85d00, #ff7a1a);
                        color:white; font-weight:800; font-size:1rem; padding:16px;
                        border:none; border-radius:12px; cursor:pointer;
                        letter-spacing:0.3px; font-family:'Montserrat',sans-serif;">

                        Konfirmasi Booking

                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
const hargaMap = {
    2: {{ $lapangan->price_2jam }},
    3: {{ $lapangan->price_3jam }},
    4: {{ $lapangan->price_4jam }},
    5: {{ $lapangan->price_5jam }},
};

const slotErrorDiv = document.getElementById('slotError');
const bookingDateInput = document.getElementById('booking_date');
const startTimeSelect = document.getElementById('start_time');
const submitBtn = document.getElementById('submitBtn');

function formatRp(num) {
    return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function updateDurasi(dur) {

    [2,3,4,5].forEach(d => {

        const lbl = document.getElementById('dur-lbl-' + d);

        if (!lbl) return;

        lbl.style.border = '1px solid #2a2a2a';
        lbl.style.background = '#1a1a1a';

        lbl.querySelector('.dur-jam').style.color = '#fff';
    });

    const sel = document.getElementById('dur-lbl-' + dur);

    if (sel) {
        sel.style.border = '1px solid rgba(232,93,0,0.6)';
        sel.style.background = 'rgba(232,93,0,0.12)';
        sel.querySelector('.dur-jam').style.color = '#ff7a1a';
    }

    document.getElementById('summDurasi').textContent = dur + ' Jam';
    document.getElementById('summHarga').textContent = formatRp(hargaMap[dur]);

    if (bookingDateInput.value && startTimeSelect.value) {
        checkSlotAvailability();
    }
}

function updatePayment(method) {

    ['cash','qris'].forEach(m => {

        const lbl = document.getElementById('pay-lbl-' + m);

        if (lbl) {
            lbl.style.border = '1px solid #2a2a2a';
            lbl.style.background = '#1a1a1a';
        }
    });

    const sel = document.getElementById('pay-lbl-' + method);

    if (sel) {
        sel.style.border = '1px solid rgba(232,93,0,0.6)';
        sel.style.background = 'rgba(232,93,0,0.12)';
    }

    if (method === 'qris') {
        document.getElementById('qrisSection').style.display = 'block';
        document.getElementById('cashInfo').style.display = 'none';
    } else {
        document.getElementById('qrisSection').style.display = 'none';
        document.getElementById('cashInfo').style.display = 'block';
    }
}

function checkSlotAvailability() {

    const date = bookingDateInput.value;
    const startTime = startTimeSelect.value;
    const lapanganId = {{ $lapangan->id }};

    if (!date || !startTime) {
        slotErrorDiv.style.display = 'none';
        submitBtn.disabled = false;
        return;
    }

    slotErrorDiv.innerHTML = 'Mengecek ketersediaan...';
    slotErrorDiv.style.display = 'block';
    slotErrorDiv.style.color = '#ffcc00';

    fetch(`/check-slot?lapangan_id=${lapanganId}&date=${date}&start_time=${startTime}`)
        .then(response => response.json())
        .then(data => {

            if (data.available) {

                slotErrorDiv.innerHTML = 'Slot tersedia';
                slotErrorDiv.style.color = '#4ade80';

                submitBtn.disabled = false;

            } else {

                slotErrorDiv.innerHTML = data.message;
                slotErrorDiv.style.color = '#ff6b6b';

                submitBtn.disabled = true;
            }
        })
        .catch(error => {

            console.error(error);

            slotErrorDiv.innerHTML = 'Gagal mengecek slot';
            slotErrorDiv.style.color = '#ff6b6b';

            submitBtn.disabled = false;
        });
}

bookingDateInput.addEventListener('change', checkSlotAvailability);
startTimeSelect.addEventListener('change', checkSlotAvailability);

document.addEventListener('DOMContentLoaded', () => {

    const defaultDur = {{ request('duration', 2) }};

    updateDurasi(defaultDur);

    const radio = document.querySelector(`input[name=duration_hours][value="${defaultDur}"]`);

    if (radio) {
        radio.checked = true;
    }

    updatePayment('cash');
});
</script>

@endsection