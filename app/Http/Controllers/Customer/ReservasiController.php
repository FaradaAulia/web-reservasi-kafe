<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Reservasi;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\KategoriMenu;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function create()
    {
        $meja = Meja::where(
            'status',
            'tersedia'
        )->get();

        $menu = Menu::where(
            'status',
            'tersedia'
        )->get();

        return view(
            'customer.reservasi',
            compact(
                'meja',
                'menu'
            )
        );
    }

    /**
     * Display the reservation form and handle availability checks.
     */
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $jam_mulai = $request->input('jam_mulai');
        $jam_selesai = $request->input('jam_selesai');

        $mejas = collect();
        $message = '';

        if ($tanggal && $jam_mulai && $jam_selesai) {
            // Find meja IDs that are already booked for the given slot
            $booked = Reservasi::where('tanggal', $tanggal)
                ->whereIn('status', ['menunggu_pembayaran', 'dibayar'])
                ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                    $query->whereBetween('jam_mulai', [$jam_mulai, $jam_selesai])
                        ->orWhereBetween('jam_selesai', [$jam_mulai, $jam_selesai]);
                })
                ->pluck('meja_id')
                ->toArray();

            $mejas = Meja::where('status', 'tersedia')
                ->whereNotIn('id', $booked)
                ->get();

            if ($mejas->isEmpty()) {
                $message = 'Tidak ada meja tersedia pada jadwal tersebut.';
            }
        }

        $categories = KategoriMenu::with(['menu' => function ($q) {
            $q->where('status', 'tersedia');
        }])->get();

        return view('customer.reservasi', compact('mejas', 'categories', 'tanggal', 'jam_mulai', 'jam_selesai', 'message'));
    }

    public function store(Request $request)
    {
        $totalQty = array_sum($request->qty);

        if ($totalQty <= 0) {
            return back()->with('error', 'Minimal pesan 1 menu');
        }

        $cekBentrok = Reservasi::where('meja_id', $request->meja_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', [
                'menunggu_pembayaran',
                'dibayar',
            ])
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [
                    $request->jam_mulai,
                    $request->jam_selesai,
                ])
                ->orWhereBetween('jam_selesai', [
                    $request->jam_mulai,
                    $request->jam_selesai,
                ]);
            })
            ->exists();

        if ($cekBentrok) {
            return back()->with('error', 'Maaf, Meja sudah dipesan pada jam tersebut');
        }

        $kode = 'RSV-' . time();

        $reservasi = Reservasi::create([
            'user_id' => auth()->id(),
            'meja_id' => $request->meja_id,
            'kode_reservasi' => $kode,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'menunggu_pembayaran',
        ]);

        $pesanan = Pesanan::create([
            'reservasi_id' => $reservasi->id,
            'total' => 0,
        ]);

        $total = 0;

        foreach ($request->qty as $menu_id => $qty) {
            if ($qty > 0) {
                $menu = Menu::find($menu_id);

                $subtotal = $menu->harga * $qty;

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $menu_id,
                    'qty' => $qty,
                    'harga' => $menu->harga,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }
        }

        $pesanan->update(['total' => $total]);

        $reservasi->update(['total_harga' => $total]);

        return redirect()->route('customer.checkout.index', $reservasi->id);
    }

    /**
     * Store a reservation submitted by a guest (not authenticated).
     */
    public function storeGuest(Request $request)
    {
        $rules = [
            'meja_id' => 'required|exists:mejas,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'qty' => 'required|array',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];

        $data = $request->validate($rules);

        $totalQty = array_sum($request->qty ?? []);

        if ($totalQty <= 0) {
            return back()->with('error', 'Minimal pesan 1 menu');
        }

        $cekBentrok = Reservasi::where('meja_id', $request->meja_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['menunggu_pembayaran', 'dibayar'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })->exists();

        if ($cekBentrok) {
            return back()->with('error', 'Maaf, Meja sudah dipesan pada jam tersebut');
        }

        $kode = 'RSV-' . time();

        $reservasi = Reservasi::create([
            'user_id' => null,
            'guest_name' => $request->name,
            'guest_email' => $request->email,
            'meja_id' => $request->meja_id,
            'kode_reservasi' => $kode,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'menunggu_pembayaran',
        ]);

        $pesanan = Pesanan::create(['reservasi_id' => $reservasi->id, 'total' => 0]);

        $total = 0;
        foreach ($request->qty as $menu_id => $qty) {
            if ($qty > 0) {
                $menu = Menu::find($menu_id);
                $subtotal = $menu->harga * $qty;
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $menu_id,
                    'qty' => $qty,
                    'harga' => $menu->harga,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
        }

        $pesanan->update(['total' => $total]);
        $reservasi->update(['total_harga' => $total]);

        return redirect()->route('customer.checkout.index', $reservasi->id);
    }

    /**
     * Show a success page for a reservation if view exists, otherwise redirect to checkout.
     */
    public function sukses($id)
    {
        $reservasi = Reservasi::with('pesanan.detailPesanan.menu')->find($id);

        if (view()->exists('customer.reservasi-sukses')) {
            return view('customer.reservasi-sukses', compact('reservasi'));
        }

        return redirect()->route('customer.checkout.index', $id);
    }
}