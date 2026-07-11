@extends('layouts.app')
@section('title', 'Grades')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Grades</h1>
        <p class="text-sm text-slate-500">Review and approve student grades.</p>
    </div>
    <a href="{{ route('admin.reports.grades') }}" class="px-4 py-2 rounded-lg bg-white border border-slate-200 text-sm font-medium">Export PDF</a>
</div>

<div class="bg-white rounded-card shadow-soft p-5 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="class_id" class="px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">All Classes</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
            @endforeach
        </select>
        <select name="subject_id" class="px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">All Subjects</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" @selected(request('subject_id') == $subject->id)>{{ $subject->name }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2 rounded-lg bg-slate-100 text-sm font-medium">Filter</button>
    </form>
</div>

<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr><th class="px-5 py-3 font-medium">Student</th><th class="px-5 py-3 font-medium">Subject</th><th class="px-5 py-3 font-medium">Average</th><th class="px-5 py-3 font-medium">Grade</th><th class="px-5 py-3 font-medium">Status</th><th class="px-5 py-3 font-medium text-right">Actions</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($grades as $grade)
                <tr>
                    <td class="px-5 py-3">{{ $grade->student->user->name }}</td>
                    <td class="px-5 py-3">{{ $grade->subject->name }}</td>
                    <td class="px-5 py-3">{{ $grade->average }}</td>
                    <td class="px-5 py-3 font-semibold">{{ $grade->grade }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $grade->approved ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }}">
                            {{ $grade->approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        @unless($grade->approved)
                            <form action="{{ route('admin.grades.approve', $grade) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-brand hover:underline text-xs font-medium">Approve</button>
                            </form>
                        @endunless
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-5 py-8 text-center text-slate-400">No grades found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $grades->links() }}</div>
@endsection
