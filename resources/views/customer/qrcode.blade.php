@extends('layouts.customer')

@section('content')
<div class="max-w-3xl mx-auto bg-stone-900 rounded-3xl border border-stone-800 p-8 shadow-xl">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-white mb-2">QR Code Reservasi</h2>
        <p class="text-stone-400">Tunjukkan QR code ini ke petugas saat datang ke restoran.</p>
    </div>

    <div class="bg-stone-950/90 p-6 rounded-3xl ring-1 ring-stone-800 mb-6 flex justify-center">
        {!! QrCode::size(300)->generate($reservasi->kode_reservasi) !!}
    </div>

    <p class="text-center text-stone-300 mb-8"><strong>Kode Reservasi:</strong> {{ $reservasi->kode_reservasi }}</p>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('customer.reservasi.sukses', $reservasi->id) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-stone-700 px-5 py-3 text-stone-200 hover:bg-stone-600">Kembali</a>
        <a href="{{ route('customer.home') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-5 py-3 text-stone-950 hover:bg-amber-400">Dashboard</a>
    </div>
</div>
@endsection
