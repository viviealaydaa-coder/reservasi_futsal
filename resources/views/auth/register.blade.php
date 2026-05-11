@extends('layouts.app')

@section('title', 'Daftar — KickIn')

@push('styles')
<style>
    .auth-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: stretch;
    }
    .auth-image-side {
        flex: 1;
        background-image: url('https://images.unsplash.com/photo-1614632537423-1e6c2e7e0aab?w=1200&auto=format&fit=crop&q=80');
        background-size: cover;
        background-position: center;
        position: relative;
        display: none;
    }
    @media(min-width: 992px) {
        .auth-image-side { display: block; }
    }
    .auth-image-side::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0,0,0,0.55) 0%, rgba(232,93,0,0.25) 100%);
    }
    .auth-image-overlay {
        position: absolute;
        bottom: 40px;
        left: 36px;
        z-index: 2;
    }
    .auth-form-side {
        width: 100%;
        max-width: 520px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 36px;
        background: #111111;
    }
    .auth-card { width: 100%; }
    .auth-input-group { position: relative; margin-bottom: 14px; }
    .auth-input-group label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.8px;
        color: #999;
        margin-bottom: 6px;
        text-transform: uppercase;
    }
    .auth-input-group input {
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
    .auth-input-group input:focus {
        border-color: #e85d00;
        box-shadow: 0 0 0 3px rgba(232,93,0,0.12);
        background: #1a1a1a;
    }
    .auth-input-group .input-icon {
        position: absolute;
        left: 14px;
        bottom: 13px;
        color: #555;
        font-size: 15px;
    }
    .password-toggle {
        position: absolute;
        right: 14px;
        bottom: 13px;
        color: #555;
        cursor: pointer;
        font-size: 15px;
        z-index: 2;
    }
    .password-toggle:hover {
        color: #e85d00;
    }
    .auth-btn {
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
    .auth-btn:hover { opacity: 0.9; transform: translateY(-1px); }
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    {{-- Sisi Gambar --}}
    <div class="auth-image-side">
        <div class="auth-image-overlay">
            <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem; letter-spacing:2px; color:white;">
                KICK<span style="color:#e85d00;">IN</span>
            </div>
            <div style="color:rgba(255,255,255,0.75); font-size:14px; margin-top:6px;">Daftar sekarang, main langsung! ⚽</div>
        </div>
    </div>

    {{-- Sisi Form --}}
    <div class="auth-form-side" style="position:relative; overflow:hidden;">
        <div style="position:absolute; top:-80px; right:-80px; width:300px; height:300px;
            background:radial-gradient(circle, rgba(232,93,0,0.1) 0%, transparent 65%); pointer-events:none;"></div>
        <div style="position:absolute; bottom:-60px; left:-60px; width:250px; height:250px;
            background:radial-gradient(circle, rgba(255,120,0,0.06) 0%, transparent 65%); pointer-events:none;"></div>

        <div class="auth-card">
            <div style="text-align:center; margin-bottom:24px;">
                <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:26px; letter-spacing:2px; color:#f5f5f5;">
                    KICK<span style="color:#e85d00;">IN</span>
                </div>
                <div style="font-size:13px; color:#777; margin-top:4px;">Buat akun baru — gratis!</div>
            </div>

            @if($errors->any())
                <div style="background:rgba(220,53,69,0.12); border:1px solid rgba(220,53,69,0.3); color:#ff6b6b;
                    border-radius:10px; padding:10px 14px; font-size:13px; margin-bottom:16px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="two-col">
                    <div class="auth-input-group">
                        <label>Nama Lengkap</label>
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama kamu" required>
                    </div>
                    <div class="auth-input-group">
                        <label>No. HP</label>
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xx-xxxx">
                    </div>
                </div>

                <div class="auth-input-group">
                    <label>Email</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                </div>

                <div class="two-col">
                    <div class="auth-input-group">
                        <label>Password</label>
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                    <div class="auth-input-group">
                        <label>Konfirmasi</label>
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required>
                        <i class="fas fa-eye password-toggle" id="togglePasswordConfirm"></i>
                    </div>
                </div>

                <div style="margin: 16px 0;">
                    <button type="submit" class="auth-btn">Buat Akun Sekarang ⚡</button>
                </div>
            </form>

            <div style="text-align:center; font-size:13px; color:#777;">
                Sudah punya akun?
                <a href="{{ route('login') }}" style="color:#e85d00; font-weight:600; text-decoration:none;">Login →</a>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
    const passwordConfirm = document.querySelector('#password_confirmation');
    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirm.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>
@endsection