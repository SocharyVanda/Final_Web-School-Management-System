<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Attendance::with(['student.user', 'subject'])
            ->when($this->filters['class_id'] ?? null, fn ($q, $v) => $q->whereHas('student', fn ($s) => $s->where('class_id', $v)))
            ->when($this->filters['subject_id'] ?? null, fn ($q, $v) => $q->where('subject_id', $v))
            ->when($this->filters['date'] ?? null, fn ($q, $v) => $q->whereDate('date', $v))
            ->orderByDesc('date')
            ->get();
    }

    public function headings(): array
    {
        return ['Student', 'Subject', 'Date', 'Status'];
    }

    public function map($attendance): array
    {
        return [
            $attendance->student->user->name,
            $attendance->subject->name,
            $attendance->date->format('Y-m-d'),
            ucfirst($attendance->status),
        ];
    }
}
