<?php

namespace App\Http\Requests\Users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'              => 'required|max:128',
            'email'             => 'required|unique:users,email',
            'password'          => 'required|min:6'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'data' => (object)[],
            'message' => $validator->errors()->first(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
