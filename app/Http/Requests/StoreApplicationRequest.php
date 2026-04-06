<?php

namespace App\Http\Requests;

use App\Models\Application;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'max:150'],
            'job_title' => ['required', 'string', 'max:150'],
            'date_applied' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', 'string', 'in:'.implode(',', Application::statuses())],
            'status_note' => ['nullable', 'string', 'max:500'],
            'expected_salary' => ['nullable', 'numeric', 'min:0'],
            'offered_salary' => ['nullable', 'numeric', 'min:0'],
            'job_location' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'Please enter the company name.',
            'job_title.required' => 'Please enter the job title.',
            'date_applied.required' => 'Please choose the date you applied.',
            'date_applied.before_or_equal' => 'The application date cannot be in the future.',
            'status.required' => 'Please choose an application status.',
            'status.in' => 'Please choose a valid application status.',
            'status_note.max' => 'The status note must be 500 characters or less.',
            'expected_salary.numeric' => 'Expected salary must be a number.',
            'offered_salary.numeric' => 'Offered salary must be a number.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'company_name' => trim((string) $this->input('company_name')),
            'job_title' => trim((string) $this->input('job_title')),
            'status_note' => trim((string) $this->input('status_note')),
            'job_location' => trim((string) $this->input('job_location')),
        ]);
    }
}
