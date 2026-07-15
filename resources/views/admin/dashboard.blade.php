@extends('admin.layouts.app')

@section('header_title', 'Dashboard Ringkasan')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat Card: Pendapatan -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase small font-weight-600">Total Pendapatan</span>
                    <h3 class="mb-0 mt-1 font-weight-700 text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-success-subtle text-success p-3 rounded-3">
                    <i class="bi bi-currency-dollar fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card: Menu -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase small font-weight-600">Total Menu</span>
                    <h3 class="mb-0 mt-1 font-weight-700 text-primary">{{ $totalMenu }}</h3>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-3">
                    <i class="bi bi-journal-richtext fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card: Meja -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase small font-weight-600">Total Meja</span>
                    <h3 class="mb-0 mt-1 font-weight-700 text-info">{{ $totalMeja }}</h3>
                </div>
                <div class="bg-info-subtle text-info p-3 rounded-3">
                    <i class="bi bi-table fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card: Reservasi -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-custom p-3">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-uppercase small font-weight-600">Total Reservasi</span>
                    <h3 class="mb-0 mt-1 font-weight-700 text-warning">{{ $totalReservasi }}</h3>
                </div>
                <div class="bg-warning-subtle text-warning p-3 rounded-3">
                    <i class="bi bi-calendar-check fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reservations -->
<div class="row">
    <div class="col-12">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="m-0 font-weight-600">Reservasi Terbaru</h5>
                <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-primary btn-sm btn-custom">
                    Lihat Semua
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Pelanggan</th>
                            <th>Tanggal & Waktu</th>
                            <th>Meja</th>
                            <th>Total Order</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservasiTerbaru as $reservasi)
                            <tr>
                                <td><span class="font-weight-600 text-dark">{{ $reservasi->kode_reservasi }}</span></td>
                                <td>{{ $reservasi->user->name ?? $reservasi->guest_name }}</td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($reservasi->tanggal)->format('d M Y') }}</div>
                                    <small class="text-muted">{{ substr($reservasi->jam_mulai, 0, 5) }} - {{ substr($reservasi->jam_selesai, 0, 5) }}</small>
                                </td>
                                <td>{{ $reservasi->meja->nomor_meja }} <small class="text-muted">(Cap: {{ $reservasi->meja->kapasitas }})</small></td>
                                <td>Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($reservasi->status == 'menunggu_pembayaran')
                                        <span class="badge badge-pending">Belum Bayar</span>
                                    @elseif($reservasi->status == 'dibayar')
                                        <span class="badge badge-success">Dibayar</span>
                                    @elseif($reservasi->status == 'selesai')
                                        <span class="badge bg-secondary-subtle text-secondary">Selesai</span>
                                    @else
                                        <span class="badge badge-danger">Batal</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-light btn-sm btn-custom">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada reservasi masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
