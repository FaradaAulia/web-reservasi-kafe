<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'reservasi_id',
        'total'
    ];

    public function reservasi()
    {
        return $this->belongsTo(
            Reservasi::class,
            'reservasi_id'
        );
    }

    public function detailPesanan()
    {
        return $this->hasMany(
            DetailPesanan::class,
            'pesanan_id'
        );
    }
}