<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorepelangganRequest extends FormRequest
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
            'username' => 'required|string|max:255|unique:pelanggans',
            'password' => 'required|string|min:8|confirmed',
            'nomor_kwh' => 'required|integer|unique:pelanggans',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'id_tarif' => 'required|exists:tarifs,id',
        ];
    }
}
