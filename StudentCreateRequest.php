<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class StudentCreateRequest extends FormRequest
{

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
            'standard' => 'required|integer',
            'capacity' => 'required|integer',
            'subject_teacher_weight.*.subject' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'subject_teacher_weight.*.teacher' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'subject_teacher_weight.*.weight' => 'required|numeric',
        ];
    }
}
