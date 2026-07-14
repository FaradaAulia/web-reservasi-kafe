@extends('layouts.customer')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="rounded-3xl border border-stone-800 bg-stone-900 p-6 text-center shadow-xl sm:p-8">
        <p class="text-xs font-semibold uppercase tracking-wider text-amber-400">QR Reservasi</p>
        <h1 class="mt-2 text-3xl font-bold text-white">Tunjukkan Saat Datang</h1>
        <p class="mx-auto mt-2 max-w-xl text-sm text-stone-400">QR code ini berisi kode reservasi Anda untuk proses check-in di kafe.</p>

        <div class="mx-auto mt-8 max-w-sm rounded-3xl border border-stone-800 bg-white p-5 shadow-lg">
            <div class="flex justify-center">
                {!! QrCode::size(280)->generate($reservasi->kode_reservasi) !!}
            </div>
        </div>

        <div class="mx-auto mt-6 max-w-md rounded-2xl border border-stone-800 bg-stone-950/70 p-4">
            <p class="text-xs uppercase tracking-wider text-stone-500">Kode Reservasi</p>
            <p class="mt-2 break-all text-xl font-bold text-amber-300">{{ $reservasi->kode_reservasi }}</p>
        </div>

        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('customer.reservasi.sukses', $reservasi->id) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-stone-700 bg-stone-950 px-5 py-3 text-sm font-semibold text-stone-300 transition hover:border-amber-500/60 hover:text-amber-300">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('customer.home') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-amber-500 px-5 py-3 text-sm font-bold text-stone-950 transition hover:bg-amber-400">
                <i class="bi bi-house"></i>
                Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
