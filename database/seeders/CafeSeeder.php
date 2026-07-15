<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriMenu;
use App\Models\Meja;
use App\Models\Menu;

class CafeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories
        $kategoriMakanan = KategoriMenu::create([
            'nama_kategori' => 'Makanan',
            'deskripsi' => 'Menu makanan berat khas Nusantara'
        ]);

        $kategoriMinuman = KategoriMenu::create([
            'nama_kategori' => 'Minuman',
            'deskripsi' => 'Pilihan minuman segar, kopi, dan teh'
        ]);

        $kategoriSnack = KategoriMenu::create([
            'nama_kategori' => 'Snack',
            'deskripsi' => 'Cemilan lezat peneman santai'
        ]);

        $kategoriPaket = KategoriMenu::create([
            'nama_kategori' => 'Paket',
            'deskripsi' => 'Paket hemat makanan dan minuman'
        ]);

        // 2. Seed Cafe Tables (Meja)
        $mejas = [
            ['nomor_meja' => 'Meja 01', 'kapasitas' => 2, 'status' => 'tersedia'],
            ['nomor_meja' => 'Meja 02', 'kapasitas' => 2, 'status' => 'tersedia'],
            ['nomor_meja' => 'Meja 03', 'kapasitas' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'Meja 04', 'kapasitas' => 4, 'status' => 'tersedia'],
            ['nomor_meja' => 'Meja 05', 'kapasitas' => 6, 'status' => 'tersedia'],
            ['nomor_meja' => 'Meja 06', 'kapasitas' => 6, 'status' => 'tersedia'],
            ['nomor_meja' => 'Meja 07', 'kapasitas' => 8, 'status' => 'tersedia', 'tipe_meja' => 'reguler'],
            ['nomor_meja' => 'Meja 08', 'kapasitas' => 8, 'status' => 'tersedia', 'tipe_meja' => 'reguler'],
            ['nomor_meja' => 'Meeting Room A', 'kapasitas' => 15, 'status' => 'tersedia', 'tipe_meja' => 'meeting_room'],
            ['nomor_meja' => 'Meeting Room B', 'kapasitas' => 20, 'status' => 'tersedia', 'tipe_meja' => 'meeting_room'],
        ];

        foreach ($mejas as $m) {
            Meja::create($m);
        }

        // 3. Seed Menu Items
        // Makanan
        Menu::create([
            'kategori_id' => $kategoriMakanan->id,
            'nama_menu' => 'Nasi Goreng Spesial',
            'deskripsi' => 'Nasi goreng dengan telur mata sapi, ayam suwir, dan kerupuk.',
            'harga' => 25000,
            'status' => 'tersedia'
        ]);
        Menu::create([
            'kategori_id' => $kategoriMakanan->id,
            'nama_menu' => 'Mie Goreng Jawa',
            'deskripsi' => 'Mie goreng khas Jawa dengan bumbu kemiri dan sayuran segar.',
            'harga' => 22000,
            'status' => 'tersedia'
        ]);
        Menu::create([
            'kategori_id' => $kategoriMakanan->id,
            'nama_menu' => 'Ayam Bakar Madu',
            'deskripsi' => 'Ayam bakar bumbu madu gurih manis disajikan dengan sambal terasi.',
            'harga' => 30000,
            'status' => 'tersedia'
        ]);

        // Minuman
        Menu::create([
            'kategori_id' => $kategoriMinuman->id,
            'nama_menu' => 'Es Kopi Susu Aren',
            'deskripsi' => 'Kopi espresso dengan susu segar dan pemanis gula aren alami.',
            'harga' => 18000,
            'status' => 'tersedia'
        ]);
        Menu::create([
            'kategori_id' => $kategoriMinuman->id,
            'nama_menu' => 'Teh Manis Dingin',
            'deskripsi' => 'Teh melati manis segar dengan es batu.',
            'harga' => 6000,
            'status' => 'tersedia'
        ]);
        Menu::create([
            'kategori_id' => $kategoriMinuman->id,
            'nama_menu' => 'Matcha Latte',
            'deskripsi' => 'Green tea bubuk premium diseduh dengan susu hangat atau es susu segar.',
            'harga' => 20000,
            'status' => 'tersedia'
        ]);

        // Snack
        Menu::create([
            'kategori_id' => $kategoriSnack->id,
            'nama_menu' => 'French Fries',
            'deskripsi' => 'Kentang goreng renyah gurih disajikan dengan saus sambal.',
            'harga' => 15000,
            'status' => 'tersedia'
        ]);
        Menu::create([
            'kategori_id' => $kategoriSnack->id,
            'nama_menu' => 'Roti Bakar Cokelat Keju',
            'deskripsi' => 'Roti bakar dengan isian cokelat lumer dan taburan keju parut berlimpah.',
            'harga' => 17000,
            'status' => 'tersedia'
        ]);
        Menu::create([
            'kategori_id' => $kategoriSnack->id,
            'nama_menu' => 'Cireng Rujak',
            'deskripsi' => 'Cireng goreng renyah kenyal disajikan dengan bumbu rujak pedas manis.',
            'harga' => 12000,
            'status' => 'tersedia'
        ]);

        // Paket
        Menu::create([
            'kategori_id' => $kategoriPaket->id,
            'nama_menu' => 'Paket Rame-rame',
            'deskripsi' => '4 Nasi Goreng Spesial + 4 Teh Manis Dingin + 2 French Fries',
            'harga' => 120000,
            'status' => 'tersedia'
        ]);
        Menu::create([
            'kategori_id' => $kategoriPaket->id,
            'nama_menu' => 'Paket Berdua',
            'deskripsi' => '2 Mie Goreng Jawa + 2 Es Kopi Susu Aren',
            'harga' => 70000,
            'status' => 'tersedia'
        ]);
    }
}
