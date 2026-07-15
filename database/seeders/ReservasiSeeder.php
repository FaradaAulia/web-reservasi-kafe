<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mejaId = \App\Models\Meja::first()->id ?? 1;

        // Bikin 10 reservasi dummy dengan pola tertentu
        for ($i = 0; $i < 10; $i++) {
            $reservasi = \App\Models\Reservasi::create([
                'user_id' => null,
                'guest_name' => 'Guest Dummy ' . $i,
                'guest_email' => 'guest' . $i . '@example.com',
                'meja_id' => $mejaId,
                'kode_reservasi' => 'RSV-DUMMY-' . $i,
                'tanggal' => now()->subDays(rand(1, 10))->format('Y-m-d'),
                'jam_mulai' => '10:00:00',
                'jam_selesai' => '12:00:00',
                'status' => 'selesai',
                'total_harga' => 0,
            ]);

            $pesanan = \App\Models\Pesanan::create([
                'reservasi_id' => $reservasi->id,
                'total' => 0,
            ]);

            // Pola 1: Nasi Goreng (1) & Es Kopi Susu Aren (4) (Sering dibeli bersama)
            if ($i % 2 == 0) {
                \App\Models\DetailPesanan::create(['pesanan_id' => $pesanan->id, 'menu_id' => 1, 'qty' => 1, 'harga' => 25000, 'subtotal' => 25000]);
                \App\Models\DetailPesanan::create(['pesanan_id' => $pesanan->id, 'menu_id' => 4, 'qty' => 1, 'harga' => 18000, 'subtotal' => 18000]);
                $pesanan->update(['total' => 43000]);
                $reservasi->update(['total_harga' => 43000]);
            } 
            // Pola 2: Ayam Bakar (3) & Teh Manis (5)
            else {
                \App\Models\DetailPesanan::create(['pesanan_id' => $pesanan->id, 'menu_id' => 3, 'qty' => 1, 'harga' => 30000, 'subtotal' => 30000]);
                \App\Models\DetailPesanan::create(['pesanan_id' => $pesanan->id, 'menu_id' => 5, 'qty' => 1, 'harga' => 6000, 'subtotal' => 6000]);
                $pesanan->update(['total' => 36000]);
                $reservasi->update(['total_harga' => 36000]);
            }
        }
    }
}
