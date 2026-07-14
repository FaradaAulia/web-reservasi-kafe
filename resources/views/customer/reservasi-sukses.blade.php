@extends('layouts.customer')

@section('content')
<div class="mx-auto max-w-4xl">
    <div class="overflow-hidden rounded-3xl border border-emerald-500/20 bg-stone-900 shadow-xl">
        <div class="p-6 text-center sm:p-10">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl border border-emerald-500/25 bg-emerald-500/10">
                <i class="bi bi-check2-circle text-3xl text-emerald-300"></i>
            </div>

            <p class="mt-6 text-xs font-semibold uppercase tracking-wider text-emerald-300">Reservasi Terkirim</p>
            <h1 class="mt-2 text-3xl font-bold text-white sm:text-4xl">Pembayaran sedang diverifikasi</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-6 text-stone-400">
                Simpan kode reservasi Anda. Setelah pembayaran disetujui admin, tunjukkan QR code saat datang ke kafe.
            </p>

            <div class="mx-auto mt-8 max-w-md rounded-3xl border border-stone-800 bg-stone-950/70 p-5">
                <p class="text-xs uppercase tracking-wider text-stone-500">Kode Reservasi</p>
                <p class="mt-2 break-all text-2xl font-bold text-amber-300">{{ $reservasi->kode_reservasi }}</p>
            </div>

            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ route('customer.checkout.qrcode', $reservasi->id) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-5 py-3 text-sm font-bold text-stone-950 transition hover:bg-emerald-400">
                    <i class="bi bi-qr-code"></i>
                    Lihat QR Code
                </a>
                <a href="{{ route('customer.home') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-stone-700 bg-stone-950 px-5 py-3 text-sm font-semibold text-stone-300 transition hover:border-amber-500/60 hover:text-amber-300">
                    <i class="bi bi-house"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
