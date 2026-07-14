<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayReservationRequest;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(int $id)
    {
        $reservasi = $this->findVisibleReservation($id)
            ->load(['pesanan.detailPesanan.menu', 'pembayaran']);

        return view('customer.checkout', compact('reservasi'));
    }

    public function bayar(PayReservationRequest $request, int $id)
    {
        $data = $request->validated();

        $reservasi = $this->findVisibleReservation($id)->load('pembayaran');

        if ($reservasi->status !== 'menunggu_pembayaran' || $reservasi->pembayaran) {
            return back()->with('error', 'Pembayaran untuk reservasi ini sudah diproses.');
        }

        $bukti = $request->file('bukti_bayar')->store('bukti-pembayaran', 'public');

        DB::transaction(function () use ($reservasi, $data, $bukti) {
            Pembayaran::create([
                'reservasi_id' => $reservasi->id,
                'metode' => $data['metode'],
                'jumlah' => $reservasi->total_harga,
                'bukti_bayar' => $bukti,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('customer.reservasi.sukses', $reservasi);
    }

    public function sukses(int $id)
    {
        $reservasi = $this->findVisibleReservation($id);

        return view('customer.reservasi-sukses', compact('reservasi'));
    }

    public function qrcode(int $id)
    {
        $reservasi = $this->findVisibleReservation($id);

        return view('customer.qrcode', compact('reservasi'));
    }

    public function batal(int $id)
    {
        $reservasi = $this->findVisibleReservation($id);

        if ($reservasi->status === 'menunggu_pembayaran') {
            $reservasi->update(['status' => 'dibatalkan']);
            return redirect()->route('customer.reservasi.index')->with('success', 'Reservasi berhasil dibatalkan. Meja sekarang tersedia kembali.');
        }

        return back()->with('error', 'Reservasi tidak dapat dibatalkan.');
    }

    private function findVisibleReservation(int $id): Reservasi
    {
        return Reservasi::query()
            ->when(auth()->check() && auth()->user()->role !== 'admin', fn ($query) => $query->where('user_id', auth()->id()))
            ->findOrFail($id);
    }
}
