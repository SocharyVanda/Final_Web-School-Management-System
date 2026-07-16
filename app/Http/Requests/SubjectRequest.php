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
            'schedules.*.end_time' => ['nullable', 'date_format:H:i'],
            'schedules.*.room' => ['nullable', 'string', 'max:50'],
            'schedules.*.color' => ['nullable', 'string', 'max:7'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $schedules = $this->input('schedules', []);
            foreach ($schedules as $i => $schedule) {
                $start = $schedule['start_time'] ?? null;
                $end = $schedule['end_time'] ?? null;
                if ($start && $end && $end <= $start) {
                    $validator->errors()->add("schedules.{$i}.end_time", 'End time must be after start time.');
                }
            }
        });
    }
}