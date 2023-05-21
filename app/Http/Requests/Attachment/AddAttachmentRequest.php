<?php

namespace App\Http\Requests\Attachment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class AddAttachmentRequest extends FormRequest
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
            'attachment'            => 'required|mimes:jpg,jpeg,png,bmp,tiff'
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'data' => (object)[],
            'message' => $validator->errors()->first(),
        ], 422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
