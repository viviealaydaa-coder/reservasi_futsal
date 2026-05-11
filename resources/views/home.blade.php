@extends('layouts.app')

@section('title', 'KickIn — Book It, Own It')

@section('content')

{{-- HERO DENGAN FONT MODERN --}}
<div style="min-height:100vh; background-image:url('https://images.unsplash.com/photo-1558453975-d6c57ab62b20?w=1600&auto=format&fit=crop&q=80'); background-size:cover; background-position:center; clip-path:ellipse(110% 92% at 50% 8%); display:flex; align-items:center; justify-content:center; position:relative;">
    <div style="position:absolute; inset:0; background:linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.7));"></div>
    <div class="container text-center" style="position:relative; z-index:1;">
        <span class="badge mb-3 px-3 py-2" style="background:rgba(255,255,255,0.12); backdrop-filter:blur(4px); color:white; border-radius:40px; font-size:0.7rem; font-weight:700; letter-spacing:2px; font-family:'Montserrat',sans-serif;">
            ⚽ F1 Futsal Booking Platform
        </span>
        <h1 class="mb-2" style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:clamp(2.8rem,7vw,5rem); line-height:1.05; letter-spacing:-1px; color:#f5f5f5;">
            KICK<span style="color:#e85d00;">IN</span>
        </h1>
        <h2 style="font-family:'Inter',sans-serif; font-weight:800; font-size:clamp(1.8rem,5vw,2.8rem); margin-bottom:1rem;">
            <span style="background:linear-gradient(90deg, #ffb347, #ff7e05); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Book It,</span>
            <span style="color:#f5f5f5;"> Own It</span>
        </h2>
        <p class="mb-4" style="max-width:560px; margin:auto; color:#ccc; font-size:1rem; font-weight:500; font-family:'Inter',sans-serif;">
            Booking lapangan futsal kapan aja, bayar Cash atau QRIS.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap mb-5">
            <a href="{{ route('lapangans.index') }}" class="btn btn-warning-custom btn-lg px-4 fw-bold" style="font-family:'Inter',sans-serif; font-weight:700;">
                🏟️ Lihat Arena
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4" style="font-family:'Inter',sans-serif; font-weight:600;">
                Daftar Gratis →
            </a>
            @endguest
        </div>
        <div class="d-flex gap-5 justify-content-center">
            <div class="text-white text-center">
                <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem;">3+</div>
                <div style="font-family:'Inter',sans-serif; font-size:0.7rem; font-weight:600; letter-spacing:1px; color:#aaa;">Lapangan</div>
            </div>
            <div style="border-left:1px solid rgba(255,255,255,0.2);"></div>
            <div class="text-white text-center">
                <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem;">24/7</div>
                <div style="font-family:'Inter',sans-serif; font-size:0.7rem; font-weight:600; letter-spacing:1px; color:#aaa;">Booking Online</div>
            </div>
            <div style="border-left:1px solid rgba(255,255,255,0.2);"></div>
            <div class="text-white text-center">
                <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem;">QRIS</div>
                <div style="font-family:'Inter',sans-serif; font-size:0.7rem; font-weight:600; letter-spacing:1px; color:#aaa;">Bayar Mudah</div>
            </div>
        </div>
    </div>
</div>

{{-- KEUNGGULAN --}}
<div class="container my-5">
    <div class="text-center mb-4">
        <span class="badge px-3 py-2 mb-2" style="background:rgba(232,93,0,0.12); color:#e85d00; border:1px solid rgba(232,93,0,0.25); border-radius:20px">Kenapa KickIn?</span>
        <h2 class="fw-bold" style="color:#ffffff">Pengalaman Booking Terbaik</h2>
    </div>
    <div class="row g-4">
        {{-- Card 1: Orange #e85d00 --}}
        <div class="col-md-4">
            <div class="card h-100 text-center p-4" style="
                border-top: 3px solid #e85d00 !important;
                border-left: 1px solid rgba(232,93,0,0.2) !important;
                border-right: 1px solid rgba(232,93,0,0.2) !important;
                border-bottom: 1px solid rgba(232,93,0,0.2) !important;
                background: linear-gradient(160deg, #1e0e00 0%, #1a1a1a 65%);
                position: relative; overflow: hidden;">
                <div style="position:absolute; top:-40px; right:-40px; width:130px; height:130px;
                    background:radial-gradient(circle, rgba(232,93,0,0.18) 0%, transparent 70%); pointer-events:none;"></div>
                <div style="width:60px; height:60px; background:rgba(232,93,0,0.12); border:1px solid rgba(232,93,0,0.35);
                    border-radius:14px; display:flex; align-items:center; justify-content:center;
                    font-size:1.6rem; margin:0 auto 16px;">🏟️</div>
                <h5 class="mt-1 fw-bold" style="color:#f5f5f5;">Lapangan Premium</h5>
                <p class="text-muted mt-2" style="font-size:0.88rem; line-height:1.7;">
                    Rumput sintetis berkualitas, lampu terang, dan fasilitas lengkap untuk kenyamanan bermain.
                </p>
                <div style="margin-top:14px; font-size:0.75rem; font-weight:700; letter-spacing:1.5px;
                    color:#e85d00; text-transform:uppercase;">Kualitas Terjamin ›</div>
            </div>
        </div>

        {{-- Card 2: Orange Light #ff7a1a --}}
        <div class="col-md-4">
            <div class="card h-100 text-center p-4" style="
                border-top: 3px solid #ff7a1a !important;
                border-left: 1px solid rgba(255,122,26,0.2) !important;
                border-right: 1px solid rgba(255,122,26,0.2) !important;
                border-bottom: 1px solid rgba(255,122,26,0.2) !important;
                background: linear-gradient(160deg, #201200 0%, #1a1a1a 65%);
                position: relative; overflow: hidden;">
                <div style="position:absolute; top:-40px; right:-40px; width:130px; height:130px;
                    background:radial-gradient(circle, rgba(255,122,26,0.16) 0%, transparent 70%); pointer-events:none;"></div>
                <div style="width:60px; height:60px; background:rgba(255,122,26,0.12); border:1px solid rgba(255,122,26,0.3);
                    border-radius:14px; display:flex; align-items:center; justify-content:center;
                    font-size:1.6rem; margin:0 auto 16px;">⚡</div>
                <h5 class="mt-1 fw-bold" style="color:#f5f5f5;">Booking Instan 24/7</h5>
                <p class="text-muted mt-2" style="font-size:0.88rem; line-height:1.7;">
                    Pesan kapan saja lewat website, konfirmasi cepat, pilih jam sesuai kebutuhan.
                </p>
                <div style="margin-top:14px; font-size:0.75rem; font-weight:700; letter-spacing:1.5px;
                    color:#ff7a1a; text-transform:uppercase;">Kapan Saja ›</div>
            </div>
        </div>

        {{-- Card 3: Orange Amber #ffb347 --}}
        <div class="col-md-4">
            <div class="card h-100 text-center p-4" style="
                border-top: 3px solid #ffb347 !important;
                border-left: 1px solid rgba(255,179,71,0.2) !important;
                border-right: 1px solid rgba(255,179,71,0.2) !important;
                border-bottom: 1px solid rgba(255,179,71,0.2) !important;
                background: linear-gradient(160deg, #1c1400 0%, #1a1a1a 65%);
                position: relative; overflow: hidden;">
                <div style="position:absolute; top:-40px; right:-40px; width:130px; height:130px;
                    background:radial-gradient(circle, rgba(255,179,71,0.13) 0%, transparent 70%); pointer-events:none;"></div>
                <div style="width:60px; height:60px; background:rgba(255,179,71,0.1); border:1px solid rgba(255,179,71,0.28);
                    border-radius:14px; display:flex; align-items:center; justify-content:center;
                    font-size:1.6rem; margin:0 auto 16px;">💳</div>
                <h5 class="mt-1 fw-bold" style="color:#f5f5f5;">Bayar Fleksibel</h5>
                <p class="text-muted mt-2" style="font-size:0.88rem; line-height:1.7;">
                    Mendukung pembayaran Cash & QRIS. Proses verifikasi cepat oleh admin kami.
                </p>
                <div style="margin-top:14px; font-size:0.75rem; font-weight:700; letter-spacing:1.5px;
                    color:#ffb347; text-transform:uppercase;">Mudah & Cepat ›</div>
            </div>
        </div>
    </div>
</div>

{{-- LAPANGAN POPULER --}}
<div style="background:linear-gradient(180deg, #0f0f0f 0%, #130e00 100%); padding:50px 0;">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge px-3 py-2 mb-2" style="background:rgba(232,93,0,0.12); color:#e85d00; border:1px solid rgba(232,93,0,0.25); border-radius:20px">Tersedia Sekarang</span>
            <h2 class="fw-bold text-white">Arena Pilihan</h2>
        </div>
        <div class="row">
            @foreach($lapangans ?? [] as $lapangan)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($lapangan->photos->first())
                    <img src="{{ asset('storage/'.$lapangan->photos->first()->photo_path) }}"
                        class="card-img-top" style="height:200px; object-fit:cover;">
                    @else
                    <div style="height:200px; background:#1a1a1a; display:flex; align-items:center; justify-content:center; border-radius:16px 16px 0 0">
                        <span style="font-size:4rem">⚽</span>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold mb-0">{{ $lapangan->name }}</h5>
                            <span class="badge bg-{{ $lapangan->type == 'indoor' ? 'info' : 'warning' }}">
                                {{ $lapangan->type == 'indoor' ? 'Indoor' : 'Outdoor' }}
                            </span>
                        </div>
                        <p class="text-muted small">{{ Str::limit($lapangan->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <div class="text-muted small">Mulai dari</div>
                                <div class="fw-bold" style="color:#ffffff; font-size:1.1rem">
                                    Rp {{ number_format($lapangan->price_2jam) }}
                                    <span style="color:#888; font-weight:400; font-size:0.82rem;">/2 jam</span>
                                </div>
                            </div>
                            <a href="{{ route('lapangans.show', $lapangan->id) }}" class="btn btn-primary btn-sm px-3">
                                Booking →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('lapangans.index') }}" class="btn btn-outline-success px-4">
                Lihat Semua Arena →
            </a>
        </div>
    </div>
</div>

{{-- CTA SECTION --}}
@guest
<div class="container my-5">
    <div class="card border-0 text-center p-5" style="background:#111111; border:1px solid #e85d00 !important; border-radius:24px;">
        <h2 class="text-white fw-bold mb-3">Siap Kick In? ⚽</h2>
        <p class="mb-4" style="opacity:0.9; color:#aaa">Daftar sekarang dan book lapangan futsal favoritmu dalam hitungan detik!</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('register') }}" class="btn btn-warning-custom fw-bold px-4">Daftar Sekarang</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light px-4">Login</a>
        </div>
    </div>
</div>
@endguest

@endsection