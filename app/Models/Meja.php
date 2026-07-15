<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'meja';

    protected $fillable = [
        'nomor_meja',
        'kapasitas',
        'status',
        'tipe_meja'
    ];

    public function reservasi()
    {
        return $this->hasMany(
            Reservasi::class,
            'meja_id'
        );
    }
}