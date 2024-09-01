<?php

namespace App\Http\Requests\v1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            'user_id' => ['required', 'string', 'unique:users,user_id'],
            'password' => ['required', 'string', 'min:8'],
            'name' => ['string'],
            'photo' => ['required'],
            'rights' => ['required']
        ];
    }

    public function failedValidation(Validator $validator){

        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag()
        ], 400));

    }
}
