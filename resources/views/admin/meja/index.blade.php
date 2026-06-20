@extends('admin.layouts.app')

@section('header_title', 'Kelola Meja Kafe')

@section('content')
<div class="row g-4">
    <!-- List Meja -->
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <h5 class="mb-4 font-weight-600">Daftar Meja</h5>
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="w-80px">No</th>
                            <th>Nomor Meja</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th class="w-150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($meja as $index => $m)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="font-weight-600 text-dark">{{ $m->nomor_meja }}</span></td>
                                <td>{{ $m->kapasitas }} Orang</td>
                                <td>
                                    @if($m->status == 'tersedia')
                                        <span class="badge badge-success">Tersedia</span>
                                    @else
                                        <span class="badge badge-pending">Dipesan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.meja.edit', $m->id) }}" class="btn btn-sm btn-outline-primary btn-custom py-1 px-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.meja.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
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
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada meja dikonfigurasi.</td>
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
                {{ isset($mejaToEdit) ? 'Edit Meja' : 'Tambah Meja Baru' }}
            </h5>
            
            <form action="{{ isset($mejaToEdit) ? route('admin.meja.update', $mejaToEdit->id) : route('admin.meja.store') }}" method="POST">
                @csrf
                @if(isset($mejaToEdit))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nomor_meja" class="form-label font-weight-500">Nomor Meja</label>
                    <input type="text" class="form-control @error('nomor_meja') is-invalid @enderror" id="nomor_meja" name="nomor_meja" value="{{ old('nomor_meja', $mejaToEdit->nomor_meja ?? '') }}" placeholder="Contoh: Meja 01" required>
                    @error('nomor_meja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label font-weight-500">Kapasitas (Orang)</label>
                    <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" id="kapasitas" name="kapasitas" value="{{ old('kapasitas', $mejaToEdit->kapasitas ?? '2') }}" min="1" required>
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label font-weight-500">Status Awal</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="tersedia" {{ old('status', $mejaToEdit->status ?? '') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="dipesan" {{ old('status', $mejaToEdit->status ?? '') == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bi {{ isset($mejaToEdit) ? 'bi-check-lg' : 'bi-plus-lg' }} me-1"></i>
                        {{ isset($mejaToEdit) ? 'Perbarui Meja' : 'Simpan Meja' }}
                    </button>
                    @if(isset($mejaToEdit))
                        <a href="{{ route('admin.meja.index') }}" class="btn btn-light btn-custom">
                            Batal
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
