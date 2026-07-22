<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class AnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['admin', 'teacher'], true);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_role' => ['required', 'in:all,admin,teacher,student'],
            'class_id' => ['nullable', 'exists:school_classes,id'],
        ];
    }
}
