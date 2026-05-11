@extends('layouts.app')

@section('title', 'Tambah Arena')

@push('styles')
<style>
    .form-wrapper {
        background: #0f0f0f;
        min-height: 100vh;
        padding: 40px 0;
    }
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background: #141414;
        border: 1px solid #2a2a2a;
        border-radius: 24px;
        overflow: hidden;
    }
    .form-header {
        background: linear-gradient(135deg, #e85d00, #ff7a1a);
        padding: 24px 30px;
    }
    .form-header h3 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 1.5rem;
    }
    .form-header p {
        color: rgba(255,255,255,0.8);
        margin: 6px 0 0;
        font-size: 0.85rem;
    }
    .form-body { padding: 30px; }
    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.8px;
        color: #999;
        margin-bottom: 6px;
        text-transform: uppercase;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 10px;
        padding: 12px 16px;
        color: #e0e0e0;
        font-size: 14px;
        outline: none;
        transition: all 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #e85d00;
        box-shadow: 0 0 0 3px rgba(232,93,0,0.1);
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .section-divider {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #e85d00;
        text-transform: uppercase;
        margin: 28px 0 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #2a2a2a;
    }
    .optional-badge {
        font-size: 10px;
        background: rgba(232,93,0,0.15);
        color: #e85d00;
        border: 1px solid rgba(232,93,0,0.3);
        border-radius: 20px;
        padding: 1px 8px;
        margin-left: 6px;
        font-weight: 600;
        text-transform: none;
        letter-spacing: 0;
    }
    .photo-section {
        background: #1a1a1a;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #2a2a2a;
    }
    .btn-save {
        background: linear-gradient(135deg, #e85d00, #ff7a1a);
        color: white;
        font-weight: 700;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-save:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-cancel {
        background: #2a2a2a;
        color: #ccc;
        font-weight: 700;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
    }
    .btn-cancel:hover { background: #3a3a3a; color: white; }
    .required-star { color: #e85d00; margin-left: 4px; }
    small {
        color: #666;
        font-size: 0.7rem;
        display: block;
        margin-top: 5px;
    }
    .error-box {
        background: rgba(220,53,69,0.15);
        border: 1px solid rgba(220,53,69,0.4);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 20px;
        color: #ff6b6b;
        font-size: 13px;
    }
    .error-box ul { margin: 0; padding-left: 18px; }
    .error-box li { margin-bottom: 4px; }
</style>
@endpush

@section('content')
<div class="form-wrapper">
    <div class="form-container">
        <div class="form-header">
            <h3><i class="fas fa-plus-circle"></i> Tambah Arena Baru</h3>
            <p>Masukkan informasi lapangan futsal</p>
        </div>

        <div class="form-body">

            @if ($errors->any())
            <div class="error-box">
                <strong>Ada kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.lapangans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Arena <span class="required-star">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Lapangan Futsal A" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe <span class="required-star">*</span></label>
                        <select name="type" required>
                            <option value="indoor" {{ old('type') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                            <option value="outdoor" {{ old('type') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="3" placeholder="Deskripsi lapangan (opsional)...">{{ old('description') }}</textarea>
                </div>

                <div class="section-divider">Harga Sewa</div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Harga 1 Jam <span class="optional-badge">Opsional</span></label>
                        <input type="number" name="price_1jam" value="{{ old('price_1jam') }}" placeholder="40000">
                    </div>
                    <div class="form-group">
                        <label>Harga 2 Jam <span class="required-star">*</span></label>
                        <input type="number" name="price_2jam" value="{{ old('price_2jam') }}" placeholder="80000" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Harga 3 Jam <span class="required-star">*</span></label>
                        <input type="number" name="price_3jam" value="{{ old('price_3jam') }}" placeholder="120000" required>
                    </div>
                    <div class="form-group">
                        <label>Harga 4 Jam <span class="required-star">*</span></label>
                        <input type="number" name="price_4jam" value="{{ old('price_4jam') }}" placeholder="160000" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Harga 5 Jam <span class="required-star">*</span></label>
                        <input type="number" name="price_5jam" value="{{ old('price_5jam') }}" placeholder="200000" required>
                    </div>
                    <div class="form-group">
                        <label>Harga 6 Jam <span class="optional-badge">Opsional</span></label>
                        <input type="number" name="price_6jam" value="{{ old('price_6jam') }}" placeholder="240000">
                    </div>
                </div>

                <div class="section-divider">Jam Operasional</div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Jam Buka <span class="required-star">*</span></label>
                        <input type="time" name="opening_time" value="{{ old('opening_time', '08:00') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Jam Tutup <span class="required-star">*</span></label>
                        <input type="time" name="closing_time" value="{{ old('closing_time', '22:00') }}" required>
                    </div>
                </div>

                <div class="photo-section">
                    <label><i class="fas fa-image"></i> Foto Arena</label>
                    <input type="file" name="photos[]" multiple accept="image/*" style="margin-top:10px; background:#1a1a1a; padding:8px; border-radius:8px; width:100%;">
                    <small>Bisa pilih lebih dari satu foto (JPG, PNG, maks 2MB per foto)</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan Arena
                    </button>
                    <a href="{{ route('admin.lapangans.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection