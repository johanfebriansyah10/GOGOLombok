<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeightRequest extends FormRequest
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
            'criteria_id' => 'required|exists:criterias,id|unique:weights,criteria_id',
            'weight' => 'required|numeric|min:0|max:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'criteria_id.required' => 'Kriteria harus dipilih.',
            'criteria_id.exists' => 'Kriteria tidak ditemukan.',
            'criteria_id.unique' => 'Kriteria ini sudah memiliki bobot.',
            'weight.required' => 'Bobot harus diisi.',
            'weight.numeric' => 'Bobot harus berupa angka.',
            'weight.min' => 'Bobot minimal 0.',
            'weight.max' => 'Bobot maksimal 1.',
        ];
    }
}
