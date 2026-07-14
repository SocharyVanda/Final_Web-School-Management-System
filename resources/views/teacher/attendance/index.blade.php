@extends('layouts.app')
@section('title', 'Attendance')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">Mark Attendance</h1>

<div class="bg-white rounded-card shadow-soft p-5 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="subject_id" onchange="this.form.submit()" class="px-3 py-2 rounded-lg border border-slate-300 text-sm">
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" @selected($subjectId == $subject->id)>{{ $subject->name }} — {{ $subject->schoolClass?->name ?? '' }}</option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </form>
</div>

@if($students->count())
<form method="POST" action="{{ route('teacher.attendance.store') }}" class="bg-white rounded-card shadow-soft overflow-hidden">
    @csrf
    <input type="hidden" name="subject_id" value="{{ $subjectId }}">
    <input type="hidden" name="date" value="{{ $date }}">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr><th class="px-5 py-3 font-medium">Student</th><th class="px-5 py-3 font-medium">Status</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($students as $student)
                @php $current = $existing[$student->id]->status ?? 'present'; @endphp
                <tr>
                    <td class="px-5 py-3">{{ $student->user?->name ?? 'Unknown' }}</td>
                    <td class="px-5 py-3">
                        <select name="statuses[{{ $student->id }}]" class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm">
                            @foreach(['present' => 'Present', 'absent' => 'Absent', 'late' => 'Late', 'excused' => 'Excused'] as $val => $label)
                                <option value="{{ $val }}" @selected($current === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-5 flex justify-end">
        <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Submit Attendance</button>
    </div>
</form>
@else
    <div class="bg-white rounded-card shadow-soft p-8 text-center text-slate-400">No students found for this subject.</div>
@endif
@endsection