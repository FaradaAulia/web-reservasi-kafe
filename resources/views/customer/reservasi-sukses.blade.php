@extends('layouts.customer')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-emerald-950/10 border border-emerald-500/20 rounded-3xl p-8 text-center shadow-xl">
        <h2 class="text-3xl font-bold text-white mb-2">Reservasi Berhasil</h2>
        <p class="text-stone-400 mb-4">Kode Reservasi :</p>
        <p class="text-amber-500 text-xl font-semibold mb-4">{{ $reservasi->kode_reservasi }}</p>
        <p class="text-stone-300 mb-6">Silahkan tunggu verifikasi admin. Kamu bisa menampilkan QR code untuk ditunjukkan saat datang.</p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('customer.checkout.qrcode', $reservasi->id) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-500 px-5 py-3 text-stone-950 hover:bg-emerald-400">Lihat QR Code</a>
            <a href="{{ route('customer.home') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-stone-700 px-5 py-3 text-stone-200 hover:bg-stone-600">Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection