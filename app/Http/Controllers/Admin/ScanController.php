<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('admin.scan');
    }

    public function check(Request $request)
    {
        $reservasi = Reservasi::where(
            'kode_reservasi',
            $request->kode
        )->first();

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