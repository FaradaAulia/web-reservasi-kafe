<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'reservasi_id',
        'metode',
        'jumlah',
        'bukti_bayar',
        'status',
        'tanggal_bayar'
    ];

    public function reservasi()
    {
        return $this->belongsTo(
            Reservasi::class,
            'reservasi_id'
        );
    }
}