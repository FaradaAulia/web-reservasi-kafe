@extends('layouts.customer')

@section('content')
<div class="space-y-8">
    <div class="bg-stone-900 rounded-3xl border border-stone-800 p-6 shadow-xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">Selamat Datang di Dashboard</h1>
                <p class="text-stone-400 mt-2">Lihat status reservasi Anda dan pesan meja baru kapan saja.</p>
            </div>
            <a href="{{ route('customer.reservasi.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-5 py-3 text-stone-950 font-semibold hover:bg-amber-400 transition">Reservasi Sekarang</a>
        </div>
    </div>

    <div class="grid gap-6">
        <div class="bg-stone-900 rounded-3xl border border-stone-800 p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-white">Reservasi Saya</h2>
                    <p class="text-stone-400 mt-1">Semua reservasi yang dibuat dengan akun Anda.</p>
                </div>
                <span class="rounded-full bg-amber-500/15 text-amber-300 px-4 py-2 text-sm font-semibold">{{ $reservations->count() }} reservasi</span>
            </div>

            @if($reservations->isEmpty())
                <div class="rounded-3xl border border-dashed border-stone-700 p-8 text-center text-stone-400">
                    Belum ada reservasi. Klik tombol "Reservasi Sekarang" untuk membuat reservasi baru.
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($reservations as $reservation)
                        <div class="bg-stone-950/10 rounded-3xl border border-stone-800 p-5 sm:flex sm:items-center sm:justify-between gap-4">
                            <div>
                                <div class="flex flex-wrap gap-2 items-center mb-3">
                                    <span class="inline-flex rounded-full bg-amber-500/15 text-amber-300 px-3 py-1 text-xs font-semibold">{{ $reservation->kode_reservasi }}</span>
                                    <span class="text-stone-400 text-sm">Meja {{ $reservation->meja?->nomor_meja ?? 'N/A' }}</span>
                                </div>
                                <p class="text-white font-semibold">{{ \Carbon\Carbon::parse($reservation->tanggal)->translatedFormat('d F Y') }}</p>
                                <p class="text-stone-400 text-sm">{{ $reservation->jam_mulai }} - {{ $reservation->jam_selesai }}</p>
                                <p class="text-stone-400 text-sm mt-2">Total: Rp {{ number_format($reservation->total_harga) }}</p>
                            </div>
                            <div class="flex flex-wrap gap-3 mt-4 sm:mt-0">
                                <span class="inline-flex items-center rounded-full bg-stone-800 px-4 py-2 text-sm font-semibold {{ $reservation->status === 'pending' ? 'text-yellow-300' : ($reservation->status === 'confirmed' ? 'text-emerald-300' : 'text-stone-300') }}">
                                    {{ ucfirst($reservation->status) }}</span>
                                <a href="{{ route('customer.reservasi.sukses', $reservation->id) }}" class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-4 py-2 text-stone-950 text-sm font-semibold hover:bg-amber-400 transition">Detail</a>
                                <a href="{{ route('customer.checkout.qrcode', $reservation->id) }}" class="inline-flex items-center justify-center rounded-2xl bg-stone-700 px-4 py-2 text-stone-200 text-sm font-semibold hover:bg-stone-600 transition">Lihat QR</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-stone-900 rounded-3xl border border-stone-800 p-6 shadow-xl">
            <h2 class="text-2xl font-bold text-white mb-4">Menu Favorit</h2>
            <div class="row g-4">
                @foreach($menu as $item)
                    <div class="col-md-4">
                        <div class="card bg-stone-950 border border-stone-800 shadow-none">
                            @if($item->foto)
                                <img src="{{ asset($item->foto) }}" alt="{{ $item->nama_menu }}" class="card-img-top menu-card-image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title text-white">{{ $item->nama_menu }}</h5>
                                <p class="card-text text-stone-400">Rp {{ number_format($item->harga) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection