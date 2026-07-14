@extends('layouts.customer')

@section('content')
@php
    $details = $reservasi->pesanan?->detailPesanan ?? collect();
    $qrisPath = public_path('qris/qris-cafe.jpg');
    $paymentMethods = [
        'Transfer Bank' => ['icon' => 'bi-bank', 'label' => 'Transfer Bank'],
        'QRIS' => ['icon' => 'bi-qr-code', 'label' => 'QRIS'],
        'E-Wallet' => ['icon' => 'bi-wallet2', 'label' => 'E-Wallet'],
    ];
@endphp

<div class="max-w-6xl mx-auto space-y-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-400">Checkout Reservasi</p>
            <h1 class="mt-2 text-3xl font-bold text-white sm:text-4xl">Selesaikan Pembayaran</h1>
            <p class="mt-2 max-w-2xl text-sm text-stone-400">
                Periksa kembali pesanan Anda, pilih metode pembayaran, lalu unggah bukti pembayaran untuk diverifikasi admin.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <span class="inline-flex items-center gap-2 rounded-2xl border border-stone-800 bg-stone-900 px-4 py-3 text-sm text-stone-300">
                <i class="bi bi-receipt-cutoff text-amber-400"></i>
                {{ $reservasi->kode_reservasi }}
            </span>
            <span class="inline-flex items-center gap-2 rounded-2xl border border-amber-500/20 bg-amber-500/10 px-4 py-3 text-sm font-semibold text-amber-300">
                <i class="bi bi-hourglass-split"></i>
                {{ str_replace('_', ' ', ucfirst($reservasi->status)) }}
            </span>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.35fr_0.65fr]">
        <section class="space-y-6">
            <div class="rounded-3xl border border-stone-800 bg-stone-900 p-6 shadow-xl">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white">Detail Reservasi</h2>
                        <p class="mt-1 text-sm text-stone-400">Meja dan jadwal kedatangan.</p>
                    </div>
                    <form action="{{ route('customer.checkout.batal', $reservasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan meja ini? Meja akan dilepas kembali ke pelanggan lain.')">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-rose-500/50 bg-rose-500/10 px-4 py-2.5 text-sm font-semibold text-rose-300 transition hover:bg-rose-500/20 hover:text-rose-200">
                            <i class="bi bi-x-circle"></i>
                            Batal & Pesan Lain
                        </button>
                    </form>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-stone-800 bg-stone-950/60 p-4">
                        <p class="text-xs uppercase tracking-wider text-stone-500">Meja</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ $reservasi->meja?->nomor_meja ?? '-' }}</p>
                    </div>
                    <div class="rounded-2xl border border-stone-800 bg-stone-950/60 p-4">
                        <p class="text-xs uppercase tracking-wider text-stone-500">Tanggal</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="rounded-2xl border border-stone-800 bg-stone-950/60 p-4">
                        <p class="text-xs uppercase tracking-wider text-stone-500">Jam</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ substr($reservasi->jam_mulai, 0, 5) }} - {{ substr($reservasi->jam_selesai, 0, 5) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-stone-800 bg-stone-900 p-6 shadow-xl">
                <div class="mb-6 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-white">Rincian Pesanan</h2>
                        <p class="mt-1 text-sm text-stone-400">{{ $details->count() }} item dipesan.</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-stone-800">
                    <div class="hidden grid-cols-[1fr_90px_150px] bg-stone-950 px-5 py-3 text-xs font-semibold uppercase tracking-wider text-stone-500 sm:grid">
                        <span>Menu</span>
                        <span class="text-center">Qty</span>
                        <span class="text-right">Subtotal</span>
                    </div>

                    <div class="divide-y divide-stone-800">
                        @forelse($details as $item)
                            <div class="grid gap-3 bg-stone-950/40 px-5 py-4 sm:grid-cols-[1fr_90px_150px] sm:items-center">
                                <div>
                                    <p class="font-semibold text-white">{{ $item->menu?->nama_menu ?? 'Menu tidak tersedia' }}</p>
                                    <p class="mt-1 text-xs text-stone-500">Rp {{ number_format($item->harga, 0, ',', '.') }} per item</p>
                                </div>
                                <div class="flex items-center justify-between sm:block sm:text-center">
                                    <span class="text-xs uppercase tracking-wider text-stone-500 sm:hidden">Qty</span>
                                    <span class="inline-flex min-w-10 justify-center rounded-xl bg-stone-900 px-3 py-1.5 text-sm font-semibold text-stone-200">{{ $item->qty }}</span>
                                </div>
                                <div class="flex items-center justify-between sm:block sm:text-right">
                                    <span class="text-xs uppercase tracking-wider text-stone-500 sm:hidden">Subtotal</span>
                                    <span class="font-semibold text-amber-300">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="bg-stone-950/40 px-5 py-8 text-center text-sm text-stone-400">
                                Belum ada item pesanan untuk reservasi ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-amber-500/20 bg-amber-500/10 p-6 shadow-xl">
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-300">Total Pembayaran</p>
                <p class="mt-3 text-3xl font-bold text-white">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</p>
                <p class="mt-2 text-sm text-stone-400">Nominal ini dihitung dari pesanan yang Anda pilih saat reservasi.</p>
            </div>

            <form action="{{ route('customer.checkout.bayar', $reservasi->id) }}" method="POST" enctype="multipart/form-data" class="rounded-3xl border border-stone-800 bg-stone-900 p-6 shadow-xl">
                @csrf

                <h2 class="text-xl font-bold text-white">Konfirmasi Pembayaran</h2>
                <p class="mt-1 text-sm text-stone-400">Pastikan bukti pembayaran jelas terbaca.</p>

                <div class="mt-6 space-y-5">
                    <div>
                        <label for="metode" class="mb-2 block text-sm font-semibold text-stone-300">Metode Pembayaran</label>
                        <select id="metode" name="metode" class="w-full rounded-2xl border border-stone-800 bg-stone-950 px-4 py-3 text-sm text-stone-200 outline-none transition focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                            @foreach($paymentMethods as $value => $method)
                                <option value="{{ $value }}" @selected(old('metode') === $value)>{{ $method['label'] }}</option>
                            @endforeach
                        </select>
                        @error('metode')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bukti_bayar" class="mb-2 block text-sm font-semibold text-stone-300">Upload Bukti Bayar</label>
                        <input id="bukti_bayar" type="file" name="bukti_bayar" accept="image/png,image/jpeg,image/webp" class="block w-full cursor-pointer rounded-2xl border border-dashed border-stone-700 bg-stone-950 px-4 py-3 text-sm text-stone-300 file:mr-4 file:rounded-xl file:border-0 file:bg-amber-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-stone-950 hover:border-amber-500/60 focus:border-amber-500 focus:outline-none">
                        <p class="mt-2 text-xs text-stone-500">Format JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                        @error('bukti_bayar')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-amber-500 px-5 py-3.5 text-sm font-bold text-stone-950 shadow-lg shadow-amber-950/20 transition hover:bg-amber-400">
                        <i class="bi bi-send-check"></i>
                        Kirim Pembayaran
                    </button>
                </div>
            </form>

            <div class="rounded-3xl border border-stone-800 bg-stone-900 p-6 shadow-xl">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-white">QRIS Cafe</h2>
                        <p class="mt-1 text-sm text-stone-400">Scan untuk pembayaran cepat.</p>
                    </div>
                    <i class="bi bi-qr-code-scan text-2xl text-amber-400"></i>
                </div>

                <div class="mt-5 rounded-2xl border border-stone-800 bg-stone-950 p-4 text-center">
                    @if(file_exists($qrisPath))
                        <img src="{{ asset('qris/qris-cafe.jpg') }}" alt="QRIS Aroma Kafe" class="mx-auto aspect-square w-full max-w-64 rounded-xl object-contain">
                    @else
                        <div class="mx-auto flex aspect-square w-full max-w-64 flex-col items-center justify-center rounded-xl border border-dashed border-stone-700 text-stone-500">
                            <i class="bi bi-image text-4xl"></i>
                            <p class="mt-3 text-sm">QRIS belum tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
