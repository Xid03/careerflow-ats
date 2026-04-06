<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInterviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stage_name' => ['required', 'string', 'max:100'],
            'interview_date' => ['nullable', 'date'],
            'mode' => ['nullable', 'string', 'max:50'],
            'result' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'stage_name.required' => 'Please enter the interview stage name.',
            'interview_date.date' => 'Please provide a valid interview date and time.',
            'mode.max' => 'Interview mode must be 50 characters or less.',
            'result.max' => 'Interview result must be 50 characters or less.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'stage_name' => trim((string) $this->input('stage_name')),
            'mode' => trim((string) $this->input('mode')),
            'result' => trim((string) $this->input('result')),
        ]);
    }
}
