<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriteriaRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:criterias,code|max:10',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:benefit,cost',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Kode kriteria harus diisi.',
            'code.unique' => 'Kode kriteria sudah ada.',
            'code.max' => 'Kode kriteria maksimal 10 karakter.',
            'name.required' => 'Nama kriteria harus diisi.',
            'name.max' => 'Nama kriteria maksimal 255 karakter.',
            'type.required' => 'Tipe kriteria harus dipilih.',
            'type.in' => 'Tipe kriteria harus benefit atau cost.',
        ];
    }
}
