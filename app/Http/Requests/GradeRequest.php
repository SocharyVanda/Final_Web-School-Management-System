<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['admin', 'teacher'], true);
    }

    public function rules(): array
    {
        return [
            'assignment' => ['required', 'numeric', 'min:0', 'max:100'],
            'quiz' => ['required', 'numeric', 'min:0', 'max:100'],
            'midterm' => ['required', 'numeric', 'min:0', 'max:100'],
            'final' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
