@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran — KickIn')

@section('content')

<div style="background:#0f0f0f; min-height:100vh; padding:40px 0 80px;">
    <div class="container">

        {{-- HEADER --}}
        <div style="text-align:center; margin-bottom:36px;">
            <span style="font-size:0.7rem; font-weight:700; letter-spacing:2px; color:#e85d00; text-transform:uppercase;">Langkah Terakhir</span>
            <h1 style="color:#ffffff; font-family:'Montserrat',sans-serif; font-weight:900; font-size:clamp(1.6rem,4vw,2.2rem); margin:8px 0 0;">
                Selesaikan Pembayaran
            </h1>
            <p style="color:#666; font-size:0.88rem; margin-top:6px;">
                Booking kamu hampir selesai — ikuti langkah di bawah ini
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            {{-- KONTEN UTAMA --}}
            <div class="col-lg-6">

                {{-- CARD INFO BOOKING --}}
                <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:24px; margin-bottom:20px;">
                    <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:16px;">
                        🎟 Detail Booking
                    </div>
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#666; font-size:0.82rem;">Kode Booking</span>
                            <span style="color:#fff; font-size:0.88rem; font-weight:700; font-family:'Montserrat',sans-serif; letter-spacing:0.5px;">
                                {{ $booking->booking_code }}
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#666; font-size:0.82rem;">Lapangan</span>
                            <span style="color:#fff; font-size:0.88rem; font-weight:600;">{{ $booking->lapangan->name }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#666; font-size:0.82rem;">Tanggal</span>
                            <span style="color:#fff; font-size:0.88rem; font-weight:600;">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#666; font-size:0.82rem;">Jam</span>
                            <span style="color:#fff; font-size:0.88rem; font-weight:600;">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#666; font-size:0.82rem;">Metode</span>
                            <span style="background:rgba(232,93,0,0.15); color:#ff7a1a; border-radius:20px; padding:3px 12px; font-size:0.78rem; font-weight:700; text-transform:uppercase;">
                                {{ strtoupper($booking->payment_method) }}
                            </span>
                        </div>
                        <div style="height:1px; background:#222;"></div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#aaa; font-size:0.9rem; font-weight:600;">Total Bayar</span>
                            <span style="color:#ff7a1a; font-size:1.2rem; font-weight:900; font-family:'Montserrat',sans-serif;">
                                Rp {{ number_format($booking->total_price) }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($booking->payment_method == 'qris')

                {{-- QRIS SECTION --}}
                <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:24px; margin-bottom:20px;">
                    <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:16px;">
                        📱 Scan QRIS untuk Bayar
                    </div>
                    <div style="text-align:center; margin-bottom:16px;">
                        <div style="display:inline-block; background:#fff; border-radius:16px; padding:16px; box-shadow:0 0 30px rgba(232,93,0,0.15);">
                            <img src="{{ asset('images/qris.jpg') }}" alt="QRIS"
                                style="width:200px; height:200px; object-fit:contain; display:block;">
                        </div>
                        <p style="color:#888; font-size:0.78rem; margin-top:12px; line-height:1.6;">
                            Buka aplikasi e-wallet / mobile banking kamu<br>lalu scan QRIS di atas
                        </p>
                    </div>
                </div>

                {{-- UPLOAD BUKTI --}}
                <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:24px; margin-bottom:20px;">
                    <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:16px;">
                        🧾 Upload Bukti Pembayaran
                    </div>

                    <form action="{{ route('bookings.uploadProof', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div style="background:#1a1a1a; border:2px dashed #333; border-radius:12px; padding:24px; text-align:center; margin-bottom:16px; transition:border 0.2s;"
                            id="uploadArea"
                            ondragover="event.preventDefault(); this.style.borderColor='#e85d00'"
                            ondragleave="this.style.borderColor='#333'"
                            ondrop="handleDrop(event)">

                            <input type="file" name="payment_proof" id="proofInput" accept="image/*"
                                style="display:none;" onchange="handleFileSelect(this)" required>

                            <div id="uploadPlaceholder">
                                <div style="font-size:2.2rem; margin-bottom:8px;">📂</div>
                                <div style="font-weight:600; color:#ccc; font-size:0.88rem; margin-bottom:4px;">Drag & drop atau klik tombol di bawah</div>
                                <div style="color:#555; font-size:0.75rem; margin-bottom:14px;">Format JPG / PNG · Maks. 2MB</div>
                                <button type="button" onclick="document.getElementById('proofInput').click()"
                                    style="background:rgba(232,93,0,0.15); border:1px solid rgba(232,93,0,0.4);
                                        color:#e85d00; border-radius:8px; padding:9px 22px;
                                        font-size:0.82rem; font-weight:700; cursor:pointer;">
                                    Pilih File
                                </button>
                            </div>

                            <div id="uploadPreview" style="display:none;">
                                <img id="previewImg" style="max-width:100%; max-height:220px; border-radius:10px; margin-bottom:10px; border:1px solid #333;">
                                <div id="previewName" style="color:#aaa; font-size:0.78rem; margin-bottom:12px;"></div>
                                <button type="button" onclick="clearFile()"
                                    style="background:rgba(255,50,50,0.1); border:1px solid rgba(255,50,50,0.3);
                                        color:#ff6b6b; border-radius:8px; padding:7px 18px;
                                        font-size:0.78rem; font-weight:600; cursor:pointer;">
                                    🗑 Hapus & Ganti
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            style="width:100%; background:linear-gradient(135deg, #e85d00, #ff7a1a);
                                color:white; font-weight:800; font-size:1rem; padding:15px;
                                border:none; border-radius:12px; cursor:pointer; letter-spacing:0.3px;
                                transition:opacity 0.2s, transform 0.2s; font-family:'Montserrat',sans-serif;"
                            onmouseenter="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                            onmouseleave="this.style.opacity='1'; this.style.transform='translateY(0)'">
                            📤 Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>

                @else

                {{-- CASH SECTION --}}
                <div style="background:#141414; border:1px solid #222; border-radius:16px; padding:28px; margin-bottom:20px;">
                    <div style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:#e85d00; text-transform:uppercase; margin-bottom:16px;">
                        💵 Instruksi Pembayaran Cash
                    </div>

                    {{-- Steps --}}
                    <div style="display:flex; flex-direction:column; gap:14px; margin-bottom:24px;">
                        @foreach([
                            ['01', 'Datang ke lokasi lapangan sesuai jadwal booking kamu'],
                            ['02', 'Tunjukkan kode booking ke petugas admin di lokasi'],
                            ['03', 'Lakukan pembayaran cash sesuai total yang tertera'],
                            ['04', 'Admin akan memverifikasi dan booking kamu aktif'],
                        ] as [$no, $text])
                        <div style="display:flex; align-items:flex-start; gap:14px;">
                            <div style="background:rgba(232,93,0,0.15); border:1px solid rgba(232,93,0,0.3);
                                color:#e85d00; font-size:0.7rem; font-weight:900; width:32px; height:32px;
                                border-radius:50%; display:flex; align-items:center; justify-content:center;
                                flex-shrink:0; font-family:'Montserrat',sans-serif;">
                                {{ $no }}
                            </div>
                            <span style="color:#999; font-size:0.85rem; line-height:1.6; padding-top:5px;">{{ $text }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Kode Booking highlight --}}
                    <div style="background:rgba(232,93,0,0.07); border:1px solid rgba(232,93,0,0.2); border-radius:12px; padding:16px; text-align:center; margin-bottom:20px;">
                        <div style="font-size:0.7rem; color:#888; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;">Kode Booking Kamu</div>
                        <div style="font-size:1.3rem; font-weight:900; color:#ff7a1a; font-family:'Montserrat',sans-serif; letter-spacing:1px;">
                            {{ $booking->booking_code }}
                        </div>
                        <div style="font-size:0.72rem; color:#666; margin-top:4px;">Tunjukkan kode ini ke admin</div>
                    </div>

                    <a href="{{ route('bookings.history') }}"
                        style="display:block; text-align:center; background:linear-gradient(135deg, #e85d00, #ff7a1a);
                            color:white; font-weight:800; font-size:1rem; padding:15px; border-radius:12px;
                            text-decoration:none; letter-spacing:0.3px; transition:opacity 0.2s, transform 0.2s;"
                        onmouseenter="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'"
                        onmouseleave="this.style.opacity='1'; this.style.transform='translateY(0)'">
                        📋 Lihat History Booking
                    </a>
                </div>

                @endif

            </div>

        </div>
    </div>
</div>

<script>
function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewName').textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
            document.getElementById('uploadPlaceholder').style.display = 'none';
            document.getElementById('uploadPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function handleDrop(e) {
    e.preventDefault();
    document.getElementById('uploadArea').style.borderColor = '#333';
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('proofInput').files = dt.files;
        handleFileSelect(document.getElementById('proofInput'));
    }
}

function clearFile() {
    document.getElementById('proofInput').value = '';
    document.getElementById('uploadPlaceholder').style.display = 'block';
    document.getElementById('uploadPreview').style.display = 'none';
}
</script>

@endsection