@extends('layouts.app')

@section('title', 'Profil Saya — KickIn')

@push('styles')
<style>
    .profile-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: stretch;
    }
    .profile-image-side {
        flex: 1;
        background-image: url('https://plus.unsplash.com/premium_photo-1661826732309-af9cab19a951?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
        background-size: cover;
        background-position: center;
        position: relative;
        display: none;
    }
    @media(min-width: 992px) {
        .profile-image-side { display: block; }
    }
    .profile-image-side::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(232,93,0,0.3) 100%);
    }
    .profile-image-overlay {
        position: absolute;
        bottom: 40px;
        left: 36px;
        z-index: 2;
    }
    .profile-form-side {
        width: 100%;
        max-width: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 36px;
        background: #111111;
    }
    .profile-card {
        width: 100%;
    }
    .profile-input-group {
        position: relative;
        margin-bottom: 20px;
    }
    .profile-input-group label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.8px;
        color: #999;
        margin-bottom: 6px;
        text-transform: uppercase;
    }
    .profile-input-group input {
        width: 100%;
        background: #161616;
        border: 1px solid #2d2d2d;
        border-radius: 10px;
        padding: 12px 16px 12px 42px;
        color: #e0e0e0;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .profile-input-group input:focus {
        border-color: #e85d00;
        box-shadow: 0 0 0 3px rgba(232,93,0,0.12);
        background: #1a1a1a;
    }
    .profile-input-group .input-icon {
        position: absolute;
        left: 14px;
        bottom: 13px;
        color: #555;
        font-size: 15px;
    }
    .profile-btn {
        width: 100%;
        background: linear-gradient(135deg, #e85d00, #ff7a1a);
        color: white;
        font-size: 15px;
        font-weight: 700;
        padding: 13px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        letter-spacing: 0.5px;
        transition: opacity 0.2s, transform 0.2s;
    }
    .profile-btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    .profile-info {
        background: #161616;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        border: 1px solid #2d2d2d;
    }
    .profile-info-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #2a2a2a;
    }
    .profile-info-item:last-child {
        border-bottom: none;
    }
    .profile-info-label {
        font-size: 12px;
        color: #888;
    }
    .profile-info-value {
        font-size: 14px;
        color: #e0e0e0;
        font-weight: 500;
    }
    .success-message {
        background: rgba(46, 204, 113, 0.12);
        border: 1px solid rgba(46, 204, 113, 0.3);
        color: #2ecc71;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="profile-wrapper">
    <div class="profile-image-side">
        <div class="profile-image-overlay">
            <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem; letter-spacing:2px; color:white;">
                KICK<span style="color:#e85d00;">IN</span>
            </div>
            <div style="color:rgba(255,255,255,0.75); font-size:14px; margin-top:6px;">Book It, Own It. ⚽</div>
        </div>
    </div>

    <div class="profile-form-side">
        <div class="profile-card">

            @if(session('success'))
                <div class="success-message">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="profile-info">
                <div class="profile-info-item">
                    <span class="profile-info-label">📧 EMAIL</span>
                    <span class="profile-info-value">{{ Auth::user()->email }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label">📅 MEMBER SEJAK</span>
                    <span class="profile-info-value">{{ Auth::user()->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="profile-input-group">
                    <label>Nama Lengkap</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <div style="color:#ff6b6b; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="profile-input-group">
                    <label>No. Telepon / WhatsApp</label>
                    <i class="fas fa-phone input-icon"></i>
                    <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <div style="color:#ff6b6b; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="profile-input-group">
                    <label>Email (tidak bisa diubah)</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" value="{{ Auth::user()->email }}" disabled style="opacity:0.7; cursor:not-allowed;">
                </div>

                <hr style="border-color:#2d2d2d; margin:20px 0;">

                <div class="profile-input-group">
                    <label>Password Baru (kosongkan jika tidak diubah)</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" placeholder="Minimal 6 karakter">
                    @error('password')
                        <div style="color:#ff6b6b; font-size:12px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="profile-input-group">
                    <label>Konfirmasi Password Baru</label>
                    <i class="fas fa-check-circle input-icon"></i>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="profile-btn">💾 Simpan Perubahan</button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <a href="{{ route('home') }}" style="color:#e85d00; font-size:13px; text-decoration:none;">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection