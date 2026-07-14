<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('subjects', 'code')->ignore($this->route('subject'))],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'class_id' => ['nullable', 'exists:school_classes,id'],
            'schedules' => ['nullable', 'array'],
            'schedules.*.day_of_week' => ['nullable', 'integer', 'between:0,6'],
            'schedules.*.start_time' => ['nullable', 'date_format:H:i'],
            'schedules.*.end_time' => ['nullable', 'date_format:H:i', 'after:schedules.*.start_time'],
            'schedules.*.room' => ['nullable', 'string', 'max:50'],
            'schedules.*.color' => ['nullable', 'string', 'max:7'],
        ];
    }
}