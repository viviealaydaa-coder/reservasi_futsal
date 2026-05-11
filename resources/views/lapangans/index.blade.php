@extends('layouts.app')

@section('title', 'KickIn — Arena Pilihan')

@push('styles')
<style>
    /* Pagination custom */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .page-item {
        list-style: none;
    }
    .page-link {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        color: #d0d0d0;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 500;
        transition: 0.2s;
    }
    .page-link:hover {
        background: #e85d00;
        border-color: #e85d00;
        color: white;
    }
    .page-item.active .page-link {
        background: #e85d00;
        border-color: #e85d00;
        color: white;
    }
    .page-item.disabled .page-link {
        background: #0f0f0f;
        color: #555;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
{{-- header dan list lapangan (tidak diubah) --}}
<div style="background:linear-gradient(180deg,#0f0f0f 0%,#130e00 100%); padding:48px 0 32px;">
    <div class="container text-center">
        <span class="badge px-3 py-2 mb-2" style="background:rgba(232,93,0,0.12); color:#e85d00; border:1px solid rgba(232,93,0,0.25); border-radius:20px;">Semua Arena</span>
        <h1 class="fw-bold text-white mb-1">Koleksi Lapangan Futsal</h1>
        <p style="color:#888; font-size:0.9rem;">Pilih lapangan terbaik dan booking sekarang</p>
    </div>
</div>

<div style="background:linear-gradient(180deg,#130e00 0%,#0f0f0f 100%); padding:40px 0 60px;">
    <div class="container">
        <div class="row">
            @foreach($lapangans as $lapangan)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    {{-- foto --}}
                    @if($lapangan->photos->first())
                    <img src="{{ asset('storage/'.$lapangan->photos->first()->photo_path) }}" class="card-img-top" style="height:220px; object-fit:cover;">
                    @else
                    <div style="height:220px; background:#1a1a1a; display:flex; align-items:center; justify-content:center; border-radius:16px 16px 0 0;">
                        <span style="font-size:4rem;">⚽</span>
                    </div>
                    @endif

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold mb-0">{{ $lapangan->name }}</h5>
                            <span class="badge bg-{{ $lapangan->type == 'indoor' ? 'info' : 'warning' }}">
                                {{ $lapangan->type == 'indoor' ? 'Indoor' : 'Outdoor' }}
                            </span>
                        </div>
                        <p class="text-muted small">{{ Str::limit($lapangan->description ?? 'Lapangan futsal berkualitas dengan fasilitas lengkap.', 100) }}</p>
                        <hr style="border-color:#2a2a2a;">
                        <p style="font-size:0.75rem; color:#e85d00; font-weight:600; letter-spacing:0.8px; text-transform:uppercase;">HARGA SEWA</p>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px 12px; font-size:0.85rem; margin-bottom:16px;">
                            <div class="d-flex justify-content-between"><span>2 jam</span><strong class="text-white">Rp {{ number_format($lapangan->price_2jam) }}</strong></div>
                            <div class="d-flex justify-content-between"><span>3 jam</span><strong class="text-white">Rp {{ number_format($lapangan->price_3jam) }}</strong></div>
                            <div class="d-flex justify-content-between"><span>4 jam</span><strong class="text-white">Rp {{ number_format($lapangan->price_4jam) }}</strong></div>
                            <div class="d-flex justify-content-between"><span>5 jam</span><strong class="text-white">Rp {{ number_format($lapangan->price_5jam) }}</strong></div>
                        </div>
                        <a href="{{ route('lapangans.show', $lapangan->id) }}" class="btn btn-primary w-100">Detail & Booking →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- PAGINATION YANG RAPI --}}
        @if($lapangans->hasPages())
        <div class="mt-5">
            {{ $lapangans->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection