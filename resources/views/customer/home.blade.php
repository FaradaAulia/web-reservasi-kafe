@extends('layouts.customer')

@section('content')
@php
    $statusStyles = [
        'menunggu_pembayaran' => 'border-amber-500/25 bg-amber-500/10 text-amber-300',
        'dibayar' => 'border-emerald-500/25 bg-emerald-500/10 text-emerald-300',
        'selesai' => 'border-sky-500/25 bg-sky-500/10 text-sky-300',
        'dibatalkan' => 'border-rose-500/25 bg-rose-500/10 text-rose-300',
    ];

    $statusLabels = [
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'dibayar' => 'Sudah Dibayar',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
@endphp

<div class="space-y-8">
    <section class="overflow-hidden rounded-3xl border border-stone-800 bg-stone-900 shadow-xl">
        <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-[1fr_320px] lg:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-400">Dashboard Pelanggan</p>
                <h1 class="mt-3 text-3xl font-bold text-white sm:text-4xl">Reservasi meja tanpa antre.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-stone-400">
                    Pantau status reservasi, lanjutkan pembayaran, dan siapkan QR reservasi sebelum datang ke Aroma Kafe.
                </p>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('customer.reservasi.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-amber-500 px-5 py-3 text-sm font-bold text-stone-950 transition hover:bg-amber-400">
                        <i class="bi bi-plus-circle"></i>
                        Reservasi Sekarang
                    </a>
                    <a href="#reservasi-saya" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-stone-700 bg-stone-950 px-5 py-3 text-sm font-semibold text-stone-300 transition hover:border-amber-500/60 hover:text-amber-300">
                        <i class="bi bi-list-check"></i>
                        Lihat Reservasi
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-2xl border border-stone-800 bg-stone-950/70 p-4">
                    <p class="text-xs uppercase tracking-wider text-stone-500">Total</p>
                    <p class="mt-2 text-3xl font-bold text-white">{{ $reservations->count() }}</p>
                    <p class="mt-1 text-xs text-stone-500">reservasi</p>
                </div>
                <div class="rounded-2xl border border-stone-800 bg-stone-950/70 p-4">
                    <p class="text-xs uppercase tracking-wider text-stone-500">Aktif</p>
                    <p class="mt-2 text-3xl font-bold text-amber-300">{{ $reservations->whereIn('status', ['menunggu_pembayaran', 'dibayar'])->count() }}</p>
                    <p class="mt-1 text-xs text-stone-500">perlu dipantau</p>
                </div>
            </div>
        </div>
    </section>

    <section id="reservasi-saya" class="rounded-3xl border border-stone-800 bg-stone-900 p-5 shadow-xl sm:p-6">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">Reservasi Saya</h2>
                <p class="mt-1 text-sm text-stone-400">Semua reservasi yang dibuat dengan akun Anda.</p>
            </div>
            <span class="inline-flex w-fit items-center gap-2 rounded-2xl border border-amber-500/20 bg-amber-500/10 px-4 py-2 text-sm font-semibold text-amber-300">
                <i class="bi bi-calendar2-check"></i>
                {{ $reservations->count() }} reservasi
            </span>
        </div>

        @if($reservations->isEmpty())
            <div class="rounded-3xl border border-dashed border-stone-700 bg-stone-950/50 p-8 text-center">
                <i class="bi bi-calendar-plus text-4xl text-stone-600"></i>
                <h3 class="mt-4 text-lg font-semibold text-white">Belum ada reservasi</h3>
                <p class="mt-2 text-sm text-stone-400">Buat reservasi pertama Anda dan pilih menu favorit sebelum datang.</p>
                <a href="{{ route('customer.reservasi.index') }}" class="mt-5 inline-flex items-center justify-center rounded-2xl bg-amber-500 px-5 py-3 text-sm font-bold text-stone-950 hover:bg-amber-400">
                    Reservasi Sekarang
                </a>
            </div>
        @else
            <div class="grid gap-4">
                @foreach($reservations as $reservation)
                    <article class="rounded-3xl border border-stone-800 bg-stone-950/50 p-5 transition hover:border-stone-700">
                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                            <div class="min-w-0">
                                <div class="mb-3 flex flex-wrap items-center gap-2">
                                    <span class="inline-flex rounded-full bg-amber-500/15 px-3 py-1 text-xs font-semibold text-amber-300">{{ $reservation->kode_reservasi }}</span>
                                    <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusStyles[$reservation->status] ?? 'border-stone-700 bg-stone-800 text-stone-300' }}">
                                        {{ $statusLabels[$reservation->status] ?? ucfirst($reservation->status) }}
                                    </span>
                                </div>

                                <div class="grid gap-3 text-sm text-stone-400 sm:grid-cols-3">
                                    <div>
                                        <p class="text-xs uppercase tracking-wider text-stone-600">Tanggal</p>
                                        <p class="mt-1 font-semibold text-white">{{ \Carbon\Carbon::parse($reservation->tanggal)->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-wider text-stone-600">Jam</p>
                                        <p class="mt-1 font-semibold text-white">{{ substr($reservation->jam_mulai, 0, 5) }} - {{ substr($reservation->jam_selesai, 0, 5) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-wider text-stone-600">Meja</p>
                                        <p class="mt-1 font-semibold text-white">{{ $reservation->meja?->nomor_meja ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row lg:items-center">
                                <div class="rounded-2xl border border-stone-800 bg-stone-900 px-4 py-3 text-left sm:text-right">
                                    <p class="text-xs uppercase tracking-wider text-stone-500">Total</p>
                                    <p class="mt-1 font-bold text-amber-300">Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('customer.reservasi.sukses', $reservation->id) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-amber-500 px-4 py-3 text-sm font-bold text-stone-950 transition hover:bg-amber-400">
                                    Detail
                                </a>
                                <a href="{{ route('customer.checkout.qrcode', $reservation->id) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-stone-700 bg-stone-900 px-4 py-3 text-sm font-semibold text-stone-300 transition hover:border-amber-500/60 hover:text-amber-300">
                                    QR
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="rounded-3xl border border-stone-800 bg-stone-900 p-5 shadow-xl sm:p-6">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">Menu Favorit</h2>
                <p class="mt-1 text-sm text-stone-400">Pilihan menu yang bisa Anda pesan saat membuat reservasi.</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($menu as $item)
                <article class="overflow-hidden rounded-3xl border border-stone-800 bg-stone-950/60 transition hover:border-stone-700">
                    @if($item->foto)
                        <img src="{{ asset($item->foto) }}" alt="{{ $item->nama_menu }}" class="menu-card-image w-full">
                    @else
                        <div class="flex h-48 items-center justify-center bg-stone-900 text-stone-600">
                            <i class="bi bi-image text-3xl"></i>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="font-bold text-white">{{ $item->nama_menu }}</h3>
                        <p class="mt-2 text-sm font-semibold text-amber-300">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</div>
@endsection
