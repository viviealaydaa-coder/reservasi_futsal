@extends('layouts.app')

@section('title', 'Kelola Arena')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="color: white; font-weight: bold; margin-bottom: 0; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Kelola Arena</h2>
            <p style="color: #d4d4d4; margin-bottom: 0;">Atur semua lapangan futsal</p>
        </div>
        <a href="{{ route('admin.lapangans.create') }}" class="btn" style="background-color: #0f5132; color: white; border-radius: 8px;">
            <i class="fas fa-plus"></i> Tambah Arena
        </a>
    </div>
    <hr style="border-top: 2px solid #0f5132; margin-top: 0; margin-bottom: 20px;">

    <div class="table-responsive">
        <table class="table table-bordered" style="border-color: #0f5132; width: 100%;">
            <thead>
                <tr style="background: linear-gradient(90deg, #b84500, #e85d00, #ff7a1a, #ff9a4a) !important; color: white !important;">
                    <th style="border: 1px solid #0f5132; padding: 12px; font-weight: bold; background: transparent; color: white;">No</th>
                    <th style="border: 1px solid #0f5132; padding: 12px; font-weight: bold; background: transparent; color: white;">Nama Arena</th>
                    <th style="border: 1px solid #0f5132; padding: 12px; font-weight: bold; background: transparent; color: white;">Tipe</th>
                    <th style="border: 1px solid #0f5132; padding: 12px; font-weight: bold; background: transparent; color: white;">Harga / 2 Jam</th>
                    <th style="border: 1px solid #0f5132; padding: 12px; font-weight: bold; background: transparent; color: white;">Jam Operasional</th>
                    <th style="border: 1px solid #0f5132; padding: 12px; font-weight: bold; background: transparent; color: white;">Status</th>
                    <th style="border: 1px solid #0f5132; padding: 12px; font-weight: bold; background: transparent; color: white;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lapangans as $index => $lapangan)
                <tr style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#f2f2f2' }};">
                    <td style="border: 1px solid #0f5132; padding: 10px;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid #0f5132; padding: 10px;"><strong>{{ $lapangan->name }}</strong></td>
                    <td style="border: 1px solid #0f5132; padding: 10px;">
                        <span style="background: {{ $lapangan->type == 'indoor' ? '#0f5132' : '#e8a800' }}; color:white; font-size:0.7rem; padding:4px 10px; border-radius:20px;">
                            {{ $lapangan->type == 'indoor' ? 'Indoor' : 'Outdoor' }}
                        </span>
                    </td>
                    <td style="border: 1px solid #0f5132; padding: 10px;">
                        <span style="color:#e85d00; font-weight:bold;">Rp {{ number_format($lapangan->price_2jam) }}</span>
                    </td>
                    <td style="border: 1px solid #0f5132; padding: 10px;">{{ $lapangan->opening_time }} - {{ $lapangan->closing_time }}</td>
                    <td style="border: 1px solid #0f5132; padding: 10px;">
                        <form action="{{ route('admin.lapangans.toggleStatus', $lapangan->id) }}" method="POST" style="margin: 0;">
                            @csrf
                            <select name="is_active" onchange="this.form.submit()" style="
                                background-color: {{ $lapangan->is_active ? '#2e7d32' : '#6c757d' }};
                                color: white;
                                border: none;
                                border-radius: 20px;
                                padding: 6px 12px;
                                font-size: 0.75rem;
                                font-weight: bold;
                                cursor: pointer;
                            ">
                                <option value="1" {{ $lapangan->is_active ? 'selected' : '' }} style="background-color: #2e7d32; color: white;">Aktif</option>
                                <option value="0" {{ !$lapangan->is_active ? 'selected' : '' }} style="background-color: #6c757d; color: white;">Nonaktif</option>
                            </select>
                        </form>
                    </td>
                    <td style="border: 1px solid #0f5132; padding: 10px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.lapangans.edit', $lapangan->id) }}" class="btn btn-sm" style="background-color: #fbbf24; color: #1a1a1a; border: none; border-radius: 6px; padding: 6px 12px;">Edit</a>
                            <form action="{{ route('admin.lapangans.destroy', $lapangan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus arena ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background-color: #dc3545; color: white; border: none; border-radius: 6px; padding: 6px 12px;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="border: 1px solid #0f5132; padding: 40px; text-align: center;">Belum ada arena. <a href="{{ route('admin.lapangans.create') }}" style="color:#e85d00;">Tambah arena pertama</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection