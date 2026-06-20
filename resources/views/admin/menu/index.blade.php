@extends('admin.layouts.app')

@section('header_title', 'Kelola Menu Kafe')

@section('content')
<div class="card card-custom p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="m-0 font-weight-600">Daftar Menu</h5>
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary btn-custom">
            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th class="w-80px">No</th>
                    <th class="w-100px">Foto</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th class="w-150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $index => $menu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($menu->foto)
                                <img src="{{ asset($menu->foto) }}" alt="{{ $menu->nama_menu }}" class="img-thumbnail table-image-thumb">
                            @else
                                <div class="bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center menu-image-placeholder">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="font-weight-600 text-dark">{{ $menu->nama_menu }}</div>
                            <small class="text-muted d-block text-truncate truncate-max-250">{{ $menu->deskripsi ?? '-' }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $menu->kategori->nama_kategori }}</span></td>
                        <td><span class="font-weight-600 text-dark">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span></td>
                        <td>
                            @if($menu->status == 'tersedia')
                                <span class="badge badge-success">Tersedia</span>
                            @else
                                <span class="badge badge-danger">Habis</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-sm btn-outline-primary btn-custom py-1 px-2">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-custom py-1 px-2">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada menu terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
