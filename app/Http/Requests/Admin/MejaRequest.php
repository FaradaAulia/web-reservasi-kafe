<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MejaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        $mejaId = $this->route('meja');

        return [
            'nomor_meja' => [
                'required',
                'string',
                'max:50',
                Rule::unique('meja', 'nomor_meja')->ignore($mejaId),
            ],
            'kapasitas' => ['required', 'integer', 'min:1', 'max:100'],
            'status' => ['required', Rule::in(['tersedia', 'dipesan'])],
        ];
    }
}
