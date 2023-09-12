<?php

namespace App\Http\Requests\Notification;

use App\Http\Responses\BaseResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreNotificationRequest extends FormRequest
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
            'owner_id' => 'required|exists:users,id',
            'target_id' => 'required|exists:users,id',
            'status' => 'required|in:accept,reject,pending',
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
