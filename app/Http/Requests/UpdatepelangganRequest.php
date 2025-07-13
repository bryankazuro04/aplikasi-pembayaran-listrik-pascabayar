<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatepelangganRequest extends FormRequest
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
            'id_tarif' => 'required|exists:tarifs,id',
            'nomor_kwh' => 'required|integer|unique:pelanggans',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ];
    }
}
