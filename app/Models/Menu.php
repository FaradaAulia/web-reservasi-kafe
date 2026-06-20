<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'kategori_id',
        'nama_menu',
        'deskripsi',
        'harga',
        'foto',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(
            KategoriMenu::class,
            'kategori_id'
        );
    }

    public function detailPesanan()
    {
        return $this->hasMany(
            DetailPesanan::class,
            'menu_id'
        );
    }
}