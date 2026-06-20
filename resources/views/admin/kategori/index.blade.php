@extends('admin.layouts.app')

@section('header_title', 'Kelola Kategori Menu')

@section('content')
<div class="row g-4">
    <!-- List Kategori -->
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <h5 class="mb-4 font-weight-600">Daftar Kategori</h5>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="w-80px">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="w-150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $index => $kat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="font-weight-600 text-dark">{{ $kat->nama_kategori }}</span></td>
                                <td>{{ $kat->deskripsi ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.kategori.edit', $kat->id) }}" class="btn btn-sm btn-outline-primary btn-custom py-1 px-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-custom py-1 px-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada kategori menu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Tambah / Edit -->
    <div class="col-lg-4">
        <div class="card card-custom p-4">
            <h5 class="mb-4 font-weight-600">
                {{ isset($kategoriToEdit) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
            </h5>
            
            <form action="{{ isset($kategoriToEdit) ? route('admin.kategori.update', $kategoriToEdit->id) : route('admin.kategori.store') }}" method="POST">
                @csrf
                @if(isset($kategoriToEdit))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label font-weight-500">Nama Kategori</label>
                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategoriToEdit->nama_kategori ?? '') }}" placeholder="Contoh: Makanan Berat" required>
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="form-label font-weight-500">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi singkat kategori...">{{ old('deskripsi', $kategoriToEdit->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bi {{ isset($kategoriToEdit) ? 'bi-check-lg' : 'bi-plus-lg' }} me-1"></i>
                        {{ isset($kategoriToEdit) ? 'Perbarui Kategori' : 'Simpan Kategori' }}
                    </button>
                    @if(isset($kategoriToEdit))
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-light btn-custom">
                            Batal
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
