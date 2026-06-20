<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservasi_id')
                ->constrained('reservasi')
                ->cascadeOnDelete();

            $table->string('metode');

            $table->decimal('jumlah', 12, 2);

            $table->string('bukti_bayar')->nullable();

            $table->enum('status', [
                'pending',
                'berhasil',
                'gagal'
            ])->default('pending');

            $table->timestamp('tanggal_bayar')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};