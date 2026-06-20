<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('meja_id')
                ->constrained('meja')
                ->cascadeOnDelete();

            $table->string('kode_reservasi')->unique();

            $table->date('tanggal');

            $table->time('jam_mulai');

            $table->time('jam_selesai');

            $table->decimal('total_harga', 12, 2)->default(0);

            $table->enum('status', [
                'menunggu_pembayaran',
                'dibayar',
                'selesai',
                'dibatalkan'
            ])->default('menunggu_pembayaran');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};