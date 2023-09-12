<?php

namespace App\Http\Requests\User;

use App\Http\Responses\BaseResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
{
    use BaseResponse;
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
            'password' => ['required', 'string', 'min:6'],
        ];
    }
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            $this->validateFailed(
                $validator->errors(),
                422
            )
        );
    }
}
