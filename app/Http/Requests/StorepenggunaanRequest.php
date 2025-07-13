<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorepenggunaanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'meter_awal' => 'required|numeric|min:0',
            'meter_akhir' => 'required|numeric|min:0|gte:meter_awal',
        ];
    }
}
