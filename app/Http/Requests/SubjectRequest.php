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

    protected function prepareForValidation(): void
    {
        $schedules = $this->input('schedules', []);
        foreach ($schedules as $i => $schedule) {
            if (!empty($schedule['start_time'])) {
                $schedules[$i]['start_time'] = $this->normalizeTime($schedule['start_time']);
            }
            if (!empty($schedule['end_time'])) {
                $schedules[$i]['end_time'] = $this->normalizeTime($schedule['end_time']);
            }
        }
        $this->merge(['schedules' => $schedules]);
    }

    private function normalizeTime(string $time): string
    {
        // Handle 12-hour formats like "10:06 AM", "04:06 PM"
        $time = trim($time);
        if (preg_match('/(\d{1,2}):(\d{2})\s*(AM|PM)/i', $time, $matches)) {
            $hour = (int) $matches[1];
            $minute = $matches[2];
            $period = strtoupper($matches[3]);
            if ($period === 'PM' && $hour !== 12) {
                $hour += 12;
            }
            if ($period === 'AM' && $hour === 12) {
                $hour = 0;
            }
            return sprintf('%02d:%s', $hour, $minute);
        }
        // Handle H:i:s format by stripping seconds
        if (preg_match('/^(\d{2}):(\d{2}):\d{2}$/', $time, $matches)) {
            return $matches[1] . ':' . $matches[2];
        }
        return $time;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $schedules = $this->input('schedules', []);
            foreach ($schedules as $i => $schedule) {
                $start = $schedule['start_time'] ?? null;
                $end = $schedule['end_time'] ?? null;
                if (!empty($start) && !empty($end) && $end <= $start) {
                    $validator->errors()->add("schedules.{$i}.end_time", 'End time must be after start time.');
                }
            }
        });
    }
}