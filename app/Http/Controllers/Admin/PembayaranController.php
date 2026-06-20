<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Meja;

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
        $pembayaran = Pembayaran::findOrFail($id);

        $pembayaran->update([
            'status' => 'berhasil',
            'tanggal_bayar' => now()
        ]);

        $pembayaran->reservasi->update([
            'status' => 'dibayar'
        ]);

        // Mark table status as booked
        $pembayaran->reservasi->meja->update([
            'status' => 'dipesan'
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi dan reservasi telah DIBAYAR!');
    }

    public function selesai($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $reservasi->update([
            'status' => 'selesai'
        ]);

        // Release the table status to tersedia
        $reservasi->meja->update([
            'status' => 'tersedia'
        ]);

        return back()->with('success', 'Reservasi ditandai SELESAI!');
    }

    public function batal($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $reservasi->update([
            'status' => 'dibatalkan'
        ]);

        // Update payment if exists to gagal
        if ($reservasi->pembayaran) {
            $reservasi->pembayaran->update([
                'status' => 'gagal'
            ]);
        }

        // Release the table status to tersedia
        $reservasi->meja->update([
            'status' => 'tersedia'
        ]);

        return back()->with('success', 'Reservasi berhasil DIBATALKAN!');
    }
}