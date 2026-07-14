<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ScanReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'kode' => ['required', 'string', 'max:50', 'regex:/^RSV-[A-Za-z0-9-]+$/'],
        ];
    }
}
