<?php

namespace App\Http\Requests\Message;

use App\Http\Responses\BaseResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMessageRequest extends FormRequest
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
            'content' => ['string', 'nullable'],
            'path' => ['string', 'nullable'],
            'is_deleted' => ['boolean'],
            'sender_id' => ['required', 'numeric'],
            'conversation_id' => ['required', 'numeric'],
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
