<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $fillable = [
        'user_id',
        'meja_id',
        'kode_reservasi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function meja()
    {
        return $this->belongsTo(
            Meja::class,
            'meja_id'
        );
    }

    public function pesanan()
    {
        return $this->hasOne(
            Pesanan::class,
            'reservasi_id'
        );
    }

    public function pembayaran()
    {
        return $this->hasOne(
            Pembayaran::class,
            'reservasi_id'
        );
    }
}