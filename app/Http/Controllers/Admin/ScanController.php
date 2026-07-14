<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScanReservationRequest;
use App\Models\Reservasi;

class ScanController extends Controller
{
    public function index()
    {
        return view('admin.scan');
    }

    public function check(ScanReservationRequest $request)
    {
        $reservasi = Reservasi::with(['user', 'meja', 'pesanan.detailPesanan.menu', 'pembayaran'])
            ->where('kode_reservasi', $request->validated('kode'))
            ->first();

        return view(
            'admin.scan',
            compact('reservasi')
        );
    }

    public function riwayat()
    {
        $reservasi = Reservasi::where(
            'user_id',
            auth()->id()
        )->latest()->get();

        return view(
            'customer.riwayat',
            compact('reservasi')
        );
    }
}
