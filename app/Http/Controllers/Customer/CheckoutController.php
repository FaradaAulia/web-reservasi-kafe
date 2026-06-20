<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index($id)
    {
        $reservasi = Reservasi::with([
            'pesanan.detailPesanan.menu'
        ])->findOrFail($id);

        return view(
            'customer.checkout',
            compact('reservasi')
        );
    }

    public function bayar(
        Request $request,
        $id
    )
    {
        $request->validate([
            'metode' => 'required',
            'bukti_bayar' => 'required|image'
        ]);

        $reservasi = Reservasi::findOrFail($id);

        $bukti = $request
            ->file('bukti_bayar')
            ->store(
                'bukti-pembayaran',
                'public'
            );

        Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'metode' => $request->metode,
            'jumlah' => $reservasi->total_harga,
            'bukti_bayar' => $bukti,
            'status' => 'pending'
        ]);

        return redirect()->route('customer.reservasi.sukses', $reservasi->id);
    }

    public function sukses($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        return view(
            'customer.reservasi-sukses',
            compact('reservasi')
        );
    }

    public function qrcode($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        return view(
            'customer.qrcode',
            compact('reservasi')
        );
    }
}