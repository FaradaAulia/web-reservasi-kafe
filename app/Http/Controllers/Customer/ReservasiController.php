<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationAvailabilityRequest;
use App\Http\Requests\StoreGuestReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Models\DetailPesanan;
use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Reservasi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ReservasiController extends Controller
{
    public function index(ReservationAvailabilityRequest $request)
    {
        $data = $request->validated();
        $tanggal = $data['tanggal'] ?? null;
        $jam_mulai = $data['jam_mulai'] ?? null;
        $jam_selesai = $data['jam_selesai'] ?? null;

        $mejas = collect();
        $message = '';

        if ($tanggal && $jam_mulai && $jam_selesai) {
            $booked = Reservasi::query()
                ->where('tanggal', $tanggal)
                ->whereIn('status', ['menunggu_pembayaran', 'dibayar'])
                ->where('jam_mulai', '<', $jam_selesai)
                ->where('jam_selesai', '>', $jam_mulai)
                ->pluck('meja_id');

            $mejas = Meja::query()
                ->where('status', 'tersedia')
                ->whereNotIn('id', $booked)
                ->orderBy('nomor_meja')
                ->get();

            if ($mejas->isEmpty()) {
                $message = 'Tidak ada meja tersedia pada jadwal tersebut.';
            }
        }

        $categories = KategoriMenu::query()
            ->with(['menu' => fn ($query) => $query->where('status', 'tersedia')->orderBy('nama_menu')])
            ->orderBy('nama_kategori')
            ->get();

        return view('customer.reservasi', compact('mejas', 'categories', 'tanggal', 'jam_mulai', 'jam_selesai', 'message'));
    }

    public function store(StoreReservationRequest $request)
    {
        $reservasi = $this->createReservation($request->validated(), auth()->id());

        return redirect()->route('customer.checkout.index', $reservasi);
    }

    public function storeGuest(StoreGuestReservationRequest $request)
    {
        $data = $request->validated();

        $reservasi = $this->createReservation($data, null, [
            'guest_name' => $data['name'],
            'guest_email' => $data['email'],
        ]);

        return redirect()->route('customer.checkout.index', $reservasi);
    }

    public function sukses(int $id)
    {
        $reservasi = $this->findVisibleReservation($id)->load('pesanan.detailPesanan.menu');

        if (view()->exists('customer.reservasi-sukses')) {
            return view('customer.reservasi-sukses', compact('reservasi'));
        }

        return redirect()->route('customer.checkout.index', $reservasi);
    }

    private function createReservation(array $data, ?int $userId, array $guestData = []): Reservasi
    {
        $selectedQty = collect($data['qty'] ?? [])
            ->map(fn ($qty) => (int) $qty)
            ->filter(fn ($qty) => $qty > 0);

        if ($selectedQty->isEmpty()) {
            throw ValidationException::withMessages(['qty' => 'Minimal pesan 1 menu']);
        }

        return DB::transaction(function () use ($data, $userId, $guestData, $selectedQty) {
            // 1. Lock Meja (Parent Resource) to prevent Phantom Read concurrency issue
            $meja = Meja::where('id', $data['meja_id'])
                        ->where('status', 'tersedia')
                        ->lockForUpdate()
                        ->first();

            if (!$meja) {
                throw ValidationException::withMessages(['meja_id' => 'Meja tidak ditemukan atau sedang tidak tersedia']);
            }

            // 2. Check for overlapping reservation
            $isBooked = Reservasi::query()
                ->where('meja_id', $meja->id)
                ->where('tanggal', $data['tanggal'])
                ->whereIn('status', ['menunggu_pembayaran', 'dibayar'])
                ->where('jam_mulai', '<', $data['jam_selesai'])
                ->where('jam_selesai', '>', $data['jam_mulai'])
                ->exists();

            if ($isBooked) {
                throw ValidationException::withMessages(['meja_id' => 'Maaf, Meja sudah dipesan pada jam tersebut']);
            }

            $menus = Menu::query()
                ->whereIn('id', $selectedQty->keys())
                ->where('status', 'tersedia')
                ->get()
                ->keyBy('id');

            if ($menus->count() !== $selectedQty->count()) {
                throw ValidationException::withMessages(['qty' => 'Menu yang dipilih tidak valid atau sudah tidak tersedia']);
            }

            $reservasi = Reservasi::create(array_merge($guestData, [
                'user_id' => $userId,
                'meja_id' => $data['meja_id'],
                'kode_reservasi' => 'RSV-'.Str::upper(Str::random(12)),
                'tanggal' => $data['tanggal'],
                'jam_mulai' => $data['jam_mulai'],
                'jam_selesai' => $data['jam_selesai'],
                'status' => 'menunggu_pembayaran',
            ]));

            $pesanan = Pesanan::create([
                'reservasi_id' => $reservasi->id,
                'total' => 0,
            ]);

            $details = $this->buildOrderDetails($selectedQty, $menus, $pesanan->id);
            DetailPesanan::insert($details->values()->all());

            $total = $details->sum('subtotal');
            $pesanan->update(['total' => $total]);
            $reservasi->update(['total_harga' => $total]);

            return $reservasi;
        });
    }

    private function buildOrderDetails(Collection $selectedQty, Collection $menus, int $pesananId): Collection
    {
        return $selectedQty->map(function (int $qty, int|string $menuId) use ($menus, $pesananId) {
            $menu = $menus->get((int) $menuId);
            $subtotal = $menu->harga * $qty;

            return [
                'pesanan_id' => $pesananId,
                'menu_id' => $menu->id,
                'qty' => $qty,
                'harga' => $menu->harga,
                'subtotal' => $subtotal,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
    }

    private function findVisibleReservation(int $id): Reservasi
    {
        return Reservasi::query()
            ->when(auth()->check() && auth()->user()->role !== 'admin', fn ($query) => $query->where('user_id', auth()->id()))
            ->findOrFail($id);
    }
}
