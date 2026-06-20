<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Reservasi;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMenu = Menu::count();
        $totalMeja = Meja::count();
        $totalReservasi = Reservasi::count();
        $totalPendapatan = Pembayaran::where('status', 'berhasil')->sum('jumlah');

        $reservasiTerbaru = Reservasi::with(['user', 'meja'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMenu',
            'totalMeja',
            'totalReservasi',
            'totalPendapatan',
            'reservasiTerbaru'
        ));
    }
}
