<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGuestReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('meja_acak') && $this->meja_acak == '1') {
            $booked = \App\Models\Reservasi::query()
                ->where('tanggal', $this->tanggal)
                ->whereIn('status', ['menunggu_pembayaran', 'dibayar'])
                ->where('jam_mulai', '<', $this->jam_selesai)
                ->where('jam_selesai', '>', $this->jam_mulai)
                ->pluck('meja_id');

            $randomMeja = \App\Models\Meja::query()
                ->where('status', 'tersedia')
                ->where('tipe_meja', 'reguler')
                ->whereNotIn('id', $booked)
                ->inRandomOrder()
                ->first();

            if ($randomMeja) {
                $this->merge(['meja_id' => $randomMeja->id]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'meja_id' => ['required', 'integer', Rule::exists('meja', 'id')->where('status', 'tersedia')],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'qty' => ['required', 'array'],
            'qty.*' => ['nullable', 'integer', 'min:0', 'max:50'],
        ];
    }
}
