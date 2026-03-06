<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'bi' => ['nullable', 'string', 'max:20'],
            'course_id' => ['required', 'exists:courses,id'],
            'course_class_id' => ['nullable', 'exists:course_classes,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Introduza um email válido.',
            'phone.required' => 'O telemóvel é obrigatório.',
            'course_id.required' => 'Seleccione um curso.',
            'course_id.exists' => 'O curso seleccionado não existe.',
        ];
    }
}
