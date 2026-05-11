@extends('layouts.app')

@section('title', 'Edit Arena')

@push('styles')
<style>
    .form-wrapper { padding: 40px 0; }
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 8px 28px rgba(0,0,0,0.15);
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
        color: rgba(255,255,255,0.85);
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
        color: #333;
        margin-bottom: 6px;
        text-transform: uppercase;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        background: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 12px 16px;
        color: #1f2937;
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
        border-bottom: 1px solid #e5e7eb;
    }
    .optional-badge {
        font-size: 10px;
        background: rgba(232,93,0,0.1);
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
        background: #f9fafb;
        border-radius: 16px;
        padding: 20px;
        margin-top: 20px;
        border: 1px solid #e5e7eb;
    }
    .photo-section label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 100px));
        gap: 12px;
        margin-top: 15px;
    }
    .photo-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
    }
    .photo-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    .btn-delete-photo {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220,53,69,0.9);
        color: white;
        border: none;
        border-radius: 20px;
        width: 24px;
        height: 24px;
        font-size: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-delete-photo:hover { background: #dc3545; }
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
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
        background: #f3f4f6;
        color: #1f2937;
        font-weight: 700;
        padding: 12px 24px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
    }
    .btn-cancel:hover { background: #e5e7eb; color: #111; }
    .current-photo-label {
        font-size: 0.75rem;
        color: #e85d00;
        margin-bottom: 8px;
        display: block;
    }
    small { color: #6b7280 !important; }
    hr { border-color: #e5e7eb; }
</style>
@endpush

@section('content')
<div class="form-wrapper">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h3><i class="fas fa-edit"></i> Edit Arena</h3>
                <p>Update informasi lapangan futsal</p>
            </div>

            <div class="form-body">
                <form action="{{ route('admin.lapangans.update', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Arena</label>
                            <input type="text" name="name" value="{{ old('name', $lapangan->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="type" required>
                                <option value="indoor" {{ $lapangan->type == 'indoor' ? 'selected' : '' }}>Indoor</option>
                                <option value="outdoor" {{ $lapangan->type == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" rows="3">{{ old('description', $lapangan->description) }}</textarea>
                    </div>

                    <div class="section-divider">Harga Sewa</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Harga 1 Jam <span class="optional-badge">Opsional</span></label>
                            <input type="number" name="price_1jam" value="{{ old('price_1jam', $lapangan->price_1jam) }}" placeholder="Kosongkan jika tidak tersedia">
                        </div>
                        <div class="form-group">
                            <label>Harga 2 Jam</label>
                            <input type="number" name="price_2jam" value="{{ old('price_2jam', $lapangan->price_2jam) }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Harga 3 Jam</label>
                            <input type="number" name="price_3jam" value="{{ old('price_3jam', $lapangan->price_3jam) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Harga 4 Jam</label>
                            <input type="number" name="price_4jam" value="{{ old('price_4jam', $lapangan->price_4jam) }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Harga 5 Jam</label>
                            <input type="number" name="price_5jam" value="{{ old('price_5jam', $lapangan->price_5jam) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Harga 6 Jam <span class="optional-badge">Opsional</span></label>
                            <input type="number" name="price_6jam" value="{{ old('price_6jam', $lapangan->price_6jam) }}" placeholder="Kosongkan jika tidak tersedia">
                        </div>
                    </div>

                    <div class="section-divider">Jam Operasional</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Jam Buka</label>
                            <input type="time" name="opening_time" value="{{ old('opening_time', $lapangan->opening_time) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jam Tutup</label>
                            <input type="time" name="closing_time" value="{{ old('closing_time', $lapangan->closing_time) }}" required>
                        </div>
                    </div>

                    @if($lapangan->photos->count() > 0)
                    <div class="photo-section">
                        <label class="current-photo-label"><i class="fas fa-images"></i> Foto Saat Ini</label>
                        <div class="photo-grid">
                            @foreach($lapangan->photos as $photo)
                            <div class="photo-item">
                                <img src="{{ asset('storage/'.$photo->photo_path) }}" alt="Foto lapangan">
                                <button type="button" class="btn-delete-photo" onclick="deletePhoto({{ $photo->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="photo-section">
                        <label><i class="fas fa-upload"></i> Tambah Foto Baru</label>
                        <input type="file" name="photos[]" multiple accept="image/*" style="margin-top:10px; background:#ffffff; padding:8px; border-radius:8px; border:1px solid #d1d5db;">
                        <small>Bisa pilih lebih dari satu foto (JPG, PNG)</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.lapangans.index') }}" class="btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deletePhoto(photoId) {
    if(confirm('Yakin hapus foto ini?')) {
        fetch('{{ url("admin/lapangan-photo") }}/' + photoId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                location.reload();
            } else {
                alert('Gagal menghapus foto');
            }
        });
    }
}
</script>
@endsection