<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        // Get all payments along with their reservation and user details
        $pembayaran = Pembayaran::with(['reservasi.user', 'reservasi.meja'])
            ->latest()
            ->get();

        // Get all reservations to manage those that might not have payment records yet or need direct status management
        $reservasiList = Reservasi::with(['user', 'meja', 'pembayaran'])
            ->latest()
            ->get();

        return view('admin.pembayaran.index', compact('pembayaran', 'reservasiList'));
    }

    public function verifikasi($id)
    {
        DB::transaction(function () use ($id) {
            $pembayaran = Pembayaran::with('reservasi.meja')
                ->lockForUpdate()
                ->findOrFail($id);

            $pembayaran->update([
                'status' => 'berhasil',
                'tanggal_bayar' => now(),
            ]);

            $pembayaran->reservasi->update([
                'status' => 'dibayar',
            ]);

            $pembayaran->reservasi->meja->update([
                'status' => 'dipesan',
            ]);
        });

        return back()->with('success', 'Pembayaran berhasil diverifikasi dan reservasi telah DIBAYAR!');
    }

    public function selesai($id)
    {
        DB::transaction(function () use ($id) {
            $reservasi = Reservasi::with('meja')
                ->lockForUpdate()
                ->findOrFail($id);

            $reservasi->update([
                'status' => 'selesai',
            ]);

            $reservasi->meja->update([
                'status' => 'tersedia',
            ]);
        });

        return back()->with('success', 'Reservasi ditandai SELESAI!');
    }

    public function batal($id)
    {
        DB::transaction(function () use ($id) {
            $reservasi = Reservasi::with(['meja', 'pembayaran'])
                ->lockForUpdate()
                ->findOrFail($id);

            $reservasi->update([
                'status' => 'dibatalkan',
            ]);

            if ($reservasi->pembayaran) {
                $reservasi->pembayaran->update([
                    'status' => 'gagal',
                ]);
            }

            $reservasi->meja->update([
                'status' => 'tersedia',
            ]);
        });

        return back()->with('success', 'Reservasi berhasil DIBATALKAN!');
    }
}
