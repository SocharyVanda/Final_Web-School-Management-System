@extends('layouts.app')
@section('title', 'Student Profile')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">{{ $student->user->name }}</h1>
    <a href="{{ route('admin.students.edit', $student) }}" class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Edit</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-card shadow-soft p-6">
        <h2 class="font-semibold text-slate-800 mb-3">Profile</h2>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt class="text-slate-500">Student ID</dt><dd class="font-medium">{{ $student->student_code }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Email</dt><dd class="font-medium">{{ $student->user->email }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Class</dt><dd class="font-medium">{{ $student->schoolClass->name ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Phone</dt><dd class="font-medium">{{ $student->phone ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Guardian</dt><dd class="font-medium">{{ $student->guardian_name ?? '—' }}</dd></div>
        </dl>
    </div>
    <div class="bg-white rounded-card shadow-soft p-6 lg:col-span-2">
        <h2 class="font-semibold text-slate-800 mb-3">Grades</h2>
        <table class="w-full text-sm">
            <thead class="text-slate-400 text-left"><tr><th class="py-2">Subject</th><th>Average</th><th>Grade</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($student->grades as $grade)
                    <tr><td class="py-2">{{ $grade->subject->name }}</td><td>{{ $grade->average }}</td><td>{{ $grade->grade }}</td></tr>
                @empty
                    <tr><td colspan="3" class="py-4 text-slate-400">No grades recorded.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
