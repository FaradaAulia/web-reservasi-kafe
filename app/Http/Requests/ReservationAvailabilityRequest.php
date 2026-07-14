<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'tanggal' => ['nullable', 'date', 'after_or_equal:today'],
            'jam_mulai' => ['nullable', 'required_with:tanggal,jam_selesai', 'date_format:H:i'],
            'jam_selesai' => ['nullable', 'required_with:tanggal,jam_mulai', 'date_format:H:i', 'after:jam_mulai'],
        ];
    }
}
