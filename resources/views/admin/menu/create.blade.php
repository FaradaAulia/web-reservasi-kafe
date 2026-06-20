@extends('admin.layouts.app')

@section('header_title', 'Tambah Menu Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <h5 class="mb-4 font-weight-600">Form Tambah Menu</h5>
            
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_menu" class="form-label font-weight-500">Nama Menu</label>
                            <input type="text" class="form-control @error('nama_menu') is-invalid @enderror" id="nama_menu" name="nama_menu" value="{{ old('nama_menu') }}" placeholder="Contoh: Es Kopi Susu Aren" required>
                            @error('nama_menu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label font-weight-500">Kategori Menu</label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label font-weight-500">Harga (Rp)</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" placeholder="Contoh: 15000" min="0" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label font-weight-500">Status Ketersediaan</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label font-weight-500">Deskripsi Menu</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi rasa, porsi, atau racikan menu...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-4">
                            <label for="foto" class="form-label font-weight-500">Foto Menu (Opsional)</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                            <div class="form-text">Maksimal resolusi file gambar adalah 2MB.</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-light btn-custom">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bi bi-save me-1"></i> Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
