<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Enums\Strips;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ClassmateRequest extends FormRequest
{
    protected $payload = [];

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
        $this->attributes();

        return [
            'name' => 'required|string|min:1',
            'type_graduation' => [
                'required',
                Rule::in(Strips::values()),
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Log::error('validator.missing_required',[
            'message' => 'Missing required fields',
            'payload' => $this->all(),
            'errors' => $validator->errors()->toArray()
        ]);

        throw new HttpResponseException(
            new JsonResponse(
                [
                    'message' => 'Missing required fields',
                    'errors'  => $validator->errors()

                ],
                JsonResponse::HTTP_BAD_REQUEST
            )
        );
    }

    protected function prepareForValidation()
    {
        if ($this->has('type_graduation')) {
            $this->merge([
                'type_graduation' => strtolower($this->type_graduation),
            ]);
        }
    }
}
