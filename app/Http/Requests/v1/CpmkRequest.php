<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class CpmkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cpmk.kodecpl' => ['required'],
            'cpmk.kodecpmk' => ['required', 'unique:cpmk,kode_cpmk'],
            'cpmk.deskripsi' => ['required', 'string']
        ];
    }
}
