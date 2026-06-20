<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $reservations = Reservasi::with(['meja', 'pembayaran', 'pesanan.detailPesanan.menu'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $menu = Menu::all();

        return view('customer.home', compact('reservations', 'menu'));
    }
}
