@extends('layouts.app')

@section('title', $lapangan->name . ' — KickIn')

@section('content')

{{-- HERO FOTO LANDSCAPE --}}
<div style="position:relative; width:100%; height:420px; overflow:hidden;">
    @if($lapangan->photos->first())
    <div id="heroSlider" style="display:flex; height:100%; transition:transform 0.5s ease;">
        @foreach($lapangan->photos as $photo)
        <div style="min-width:100%; height:100%;">
            <img src="{{ asset('storage/'.$photo->photo_path) }}"
                style="width:100%; height:100%; object-fit:cover; display:block;">
        </div>
        @endforeach
    </div>
    @else
    <div style="width:100%; height:100%; background:linear-gradient(135deg,#1a0e00,#1a1a1a); display:flex; align-items:center; justify-content:center;">
        <span style="font-size:5rem; opacity:0.3;">⚽</span>
    </div>
    @endif

    {{-- Overlay gradient --}}
    <div style="position:absolute; inset:0; background:linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%); pointer-events:none;"></div>

    {{-- Judul di atas foto --}}
    <div style="position:absolute; bottom:28px; left:32px; z-index:2;">
        <span style="background:rgba(232,93,0,0.85); color:white; font-size:0.7rem; font-weight:700;
            letter-spacing:1.5px; padding:4px 12px; border-radius:20px; text-transform:uppercase; margin-bottom:10px; display:inline-block;">
            {{ $lapangan->type == 'indoor' ? '🏠 Indoor' : '🌿 Outdoor' }}
        </span>
        <h1 style="color:#ffffff; font-weight:900; font-size:clamp(1.6rem,4vw,2.4rem); font-family:'Montserrat',sans-serif;
            margin:6px 0 0; text-shadow:0 2px 12px rgba(0,0,0,0.5);">
            {{ $lapangan->name }}
        </h1>
    </div>

    {{-- Thumbnail dots & arrow jika multi foto --}}
    @if($lapangan->photos->count() > 1)
    <button onclick="slideHero(-1)" style="position:absolute; left:16px; top:50%; transform:translateY(-50%);
        background:rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.2); color:white;
        width:40px; height:40px; border-radius:50%; cursor:pointer; font-size:1rem; z-index:3;">‹</button>
    <button onclick="slideHero(1)" style="position:absolute; right:16px; top:50%; transform:translateY(-50%);
        background:rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.2); color:white;
        width:40px; height:40px; border-radius:50%; cursor:pointer; font-size:1rem; z-index:3;">›</button>

    <div id="heroDots" style="position:absolute; bottom:14px; right:20px; display:flex; gap:6px; z-index:3;">
        @foreach($lapangan->photos as $i => $p)
        <div onclick="goSlide({{ $i }})" style="width:{{ $i==0 ? '20px' : '8px' }}; height:8px; border-radius:4px;
            background:{{ $i==0 ? '#e85d00' : 'rgba(255,255,255,0.4)' }};
            cursor:pointer; transition:all 0.3s;" id="dot-{{ $i }}"></div>
        @endforeach
    </div>
    @endif
</div>

{{-- KONTEN UTAMA --}}
<div style="background:#0f0f0f; padding:36px 0 60px;">
    <div class="container">
        <div class="row g-4">

            {{-- KIRI: INFO LAPANGAN --}}
            <div class="col-lg-7">

                {{-- Deskripsi --}}
                <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:24px; margin-bottom:20px;">
                    <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:12px;">
                        Tentang Lapangan
                    </div>
                    <p style="color:#bbb; font-size:0.92rem; line-height:1.8; margin:0;">
                        {{ $lapangan->description ?? 'Lapangan futsal berkualitas dengan fasilitas lengkap untuk kenyamanan bermain.' }}
                    </p>
                </div>

                {{-- Jam Operasional --}}
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:20px; text-align:center;">
                            <div style="font-size:1.8rem; margin-bottom:8px;">🕐</div>
                            <div style="font-size:0.68rem; color:#666; font-weight:600; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">Jam Buka</div>
                            <div style="font-weight:700; color:#ffffff; font-size:1rem;">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $lapangan->opening_time)->format('g:i A') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:20px; text-align:center;">
                            <div style="font-size:1.8rem; margin-bottom:8px;">🌙</div>
                            <div style="font-size:0.68rem; color:#666; font-weight:600; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">Jam Tutup</div>
                            <div style="font-weight:700; color:#ffffff; font-size:1rem;">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $lapangan->closing_time)->format('g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Syarat & Ketentuan --}}
                <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:24px;">
                    <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:16px;">
                        Syarat & Ketentuan
                    </div>
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        @foreach([
                            ['🕑', 'Minimal booking 2 jam'],
                            ['📅', 'Maksimal booking H-1 bulan'],
                            ['✅', 'Booking sah setelah pembayaran terverifikasi'],
                            ['💵', 'Pembayaran cash wajib lunas sebelum bermain'],
                            ['⚠️', 'Denda kerusakan lapangan akan ditagih setelah pemeriksaan'],
                        ] as [$icon, $text])
                        <div style="display:flex; align-items:flex-start; gap:12px;">
                            <span style="font-size:1rem; flex-shrink:0;">{{ $icon }}</span>
                            <span style="color:#999; font-size:0.85rem; line-height:1.6;">{{ $text }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- KANAN: BOOKING CARD --}}
            <div class="col-lg-5">
                <div style="background:#141414; border:1px solid rgba(232,93,0,0.2); border-radius:16px; padding:24px; position:sticky; top:20px;">

                    {{-- Harga --}}
                    <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:16px;">
                        Pilihan Harga Sewa
                    </div>

                    <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:24px;">
                        @php
                        $hargaList = [
                            ['2 jam', $lapangan->price_2jam, true, 2],
                            ['3 jam', $lapangan->price_3jam, false, 3],
                            ['4 jam', $lapangan->price_4jam, false, 4],
                            ['5 jam', $lapangan->price_5jam, false, 5],
                        ];
                        @endphp

                        {{-- Semua card mulai abu/putih, JS yang handle highlight --}}
                        @foreach($hargaList as [$label, $price, $isMin, $dur])
                        <div onclick="selectDurasi({{ $dur }})" id="card-dur-{{ $dur }}" style="
                            display:flex; justify-content:space-between; align-items:center;
                            background:#1a1a1a;
                            border:1px solid #2a2a2a;
                            border-radius:10px;
                            padding:12px 16px;
                            cursor:pointer;
                            transition:all 0.2s;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span class="dur-label" style="font-size:0.85rem; color:#e0e0e0; font-weight:600;">{{ $label }}</span>
                                @if($isMin)
                                <span style="font-size:0.6rem; background:rgba(232,93,0,0.2); color:#e85d00; border-radius:8px; padding:2px 7px; font-weight:700; letter-spacing:0.5px;">MINIMAL</span>
                                @endif
                            </div>
                            <span class="dur-price" style="font-weight:800; color:#f0f0f0; font-size:0.95rem; font-family:'Montserrat',sans-serif;">
                                Rp {{ number_format($price) }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Divider --}}
                    <div style="height:1px; background:#222; margin-bottom:20px;"></div>

                    {{-- CTA Booking --}}
                    @auth
                    <a id="bookingBtn" href="{{ route('bookings.create', $lapangan->id) }}?duration=2" style="
                        display:block; text-align:center;
                        background:linear-gradient(135deg, #e85d00, #ff7a1a);
                        color:white; font-weight:800; font-size:1rem;
                        padding:14px; border-radius:12px;
                        text-decoration:none; letter-spacing:0.3px;
                        transition:opacity 0.2s, transform 0.2s;"
                        onmouseenter="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                        onmouseleave="this.style.opacity='1'; this.style.transform='translateY(0)'">
                        ⚽ Booking Sekarang
                    </a>
                    @endauth

                    {{-- Info tambahan --}}
                    <div style="margin-top:16px; display:flex; justify-content:center; gap:20px;">
                        <div style="text-align:center;">
                            <div style="font-size:1rem;">💳</div>
                            <div style="font-size:0.68rem; color:#555; margin-top:2px;">Cash & QRIS</div>
                        </div>
                        <div style="text-align:center;">
                            <div style="font-size:1rem;">⚡</div>
                            <div style="font-size:0.68rem; color:#555; margin-top:2px;">Konfirmasi Cepat</div>
                        </div>
                        <div style="text-align:center;">
                            <div style="font-size:1rem;">🔒</div>
                            <div style="font-size:0.68rem; color:#555; margin-top:2px;">Aman & Terpercaya</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- SLIDER JS --}}
@if($lapangan->photos->count() > 1)
<script>
let current = 0;
const total = {{ $lapangan->photos->count() }};

function updateSlider() {
    document.getElementById('heroSlider').style.transform = `translateX(-${current * 100}%)`;
    for (let i = 0; i < total; i++) {
        const dot = document.getElementById('dot-' + i);
        if (dot) {
            dot.style.width = i === current ? '20px' : '8px';
            dot.style.background = i === current ? '#e85d00' : 'rgba(255,255,255,0.4)';
        }
    }
}

function slideHero(dir) {
    current = (current + dir + total) % total;
    updateSlider();
}

function goSlide(index) {
    current = index;
    updateSlider();
}

setInterval(() => slideHero(1), 4000);
</script>
@endif

<script>
function selectDurasi(dur) {
    // Reset SEMUA card ke abu/putih dulu tanpa pengecualian
    [2,3,4,5].forEach(d => {
        const el = document.getElementById('card-dur-' + d);
        if (!el) return;
        el.style.border = '1px solid #2a2a2a';
        el.style.background = '#1a1a1a';
        el.querySelector('.dur-label').style.color = '#e0e0e0';
        el.querySelector('.dur-price').style.color = '#f0f0f0';
    });
    // Highlight card yang dipilih
    const selected = document.getElementById('card-dur-' + dur);
    if (selected) {
        selected.style.border = '1px solid rgba(232,93,0,0.6)';
        selected.style.background = 'rgba(232,93,0,0.15)';
        selected.querySelector('.dur-label').style.color = '#ff7a1a';
        selected.querySelector('.dur-price').style.color = '#ff7a1a';
    }
    // Update href tombol booking
    const btn = document.getElementById('bookingBtn');
    if (btn) btn.href = btn.href.replace(/duration=\d/, 'duration=' + dur);
}

// Default highlight card 2 jam saat halaman load
document.addEventListener('DOMContentLoaded', () => selectDurasi(2));
</script>

@endsection