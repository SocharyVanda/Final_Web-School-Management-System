@extends('layouts.app')
@section('title', 'Grades')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">Enter Grades</h1>

<div class="bg-white rounded-card shadow-soft p-5 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="subject_id" onchange="this.form.submit()" class="px-3 py-2 rounded-lg border border-slate-300 text-sm">
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" @selected($subjectId == $subject->id)>{{ $subject->name }} — {{ $subject->schoolClass?->name ?? '' }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr><th class="px-5 py-3 font-medium">Student</th><th class="px-5 py-3 font-medium">Assignment</th><th class="px-5 py-3 font-medium">Quiz</th><th class="px-5 py-3 font-medium">Midterm</th><th class="px-5 py-3 font-medium">Final</th><th class="px-5 py-3 font-medium">Average</th><th class="px-5 py-3 font-medium">Grade</th><th class="px-5 py-3 font-medium"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($grades as $grade)
                <tr>
                    <form method="POST" action="{{ route('teacher.grades.update', $grade) }}">
                        @csrf @method('PATCH')
                        <td class="px-5 py-3">{{ $grade->student?->user?->name ?? 'Unknown' }}</td>
                        <td class="px-2 py-2"><input type="number" step="0.01" name="assignment" value="{{ $grade->assignment }}" class="w-20 px-2 py-1 rounded border border-slate-300 text-sm"></td>
                        <td class="px-2 py-2"><input type="number" step="0.01" name="quiz" value="{{ $grade->quiz }}" class="w-20 px-2 py-1 rounded border border-slate-300 text-sm"></td>
                        <td class="px-2 py-2"><input type="number" step="0.01" name="midterm" value="{{ $grade->midterm }}" class="w-20 px-2 py-1 rounded border border-slate-300 text-sm"></td>
                        <td class="px-2 py-2"><input type="number" step="0.01" name="final" value="{{ $grade->final }}" class="w-20 px-2 py-1 rounded border border-slate-300 text-sm"></td>
                        <td class="px-5 py-3">{{ $grade->average ?? '—' }}</td>
                        <td class="px-5 py-3 font-semibold">{{ $grade->grade ?? '—' }}</td>
                        <td class="px-5 py-3"><button class="text-brand text-xs font-medium hover:underline">Save</button></td>
                    </form>
                </tr>
            @empty
                <tr><td colspan="8" class="px-5 py-8 text-center text-slate-400">No students in this subject.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection