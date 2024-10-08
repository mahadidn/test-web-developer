<?php

namespace App\Http\Requests\v1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CplRequest extends FormRequest
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
            "cpl.kodecpl" => ['required'],
            "cpl.deskripsi" => ['required', 'string']
        ];
    }


    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag()
        ], 400));
    }

}
