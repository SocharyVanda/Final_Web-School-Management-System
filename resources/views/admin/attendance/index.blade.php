@extends('layouts.app')
@section('title', 'Attendance')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Attendance Records</h1>
        <p class="text-sm text-slate-500">View and export attendance across all classes.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.attendance.export-pdf', request()->query()) }}" class="px-4 py-2 rounded-lg bg-white border border-slate-200 text-sm font-medium">Export PDF</a>
        <a href="{{ route('admin.attendance.export-excel', request()->query()) }}" class="px-4 py-2 rounded-lg bg-white border border-slate-200 text-sm font-medium">Export Excel</a>
    </div>
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
        <input type="date" name="date" value="{{ request('date') }}" class="px-3 py-2 rounded-lg border border-slate-300 text-sm">
        <button class="px-4 py-2 rounded-lg bg-slate-100 text-sm font-medium">Filter</button>
    </form>
</div>

<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr><th class="px-5 py-3 font-medium">Student</th><th class="px-5 py-3 font-medium">Subject</th><th class="px-5 py-3 font-medium">Date</th><th class="px-5 py-3 font-medium">Status</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($attendances as $a)
                <tr>
                    <td class="px-5 py-3">{{ $a->student?->user?->name ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $a->subject?->name ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $a->date?->format('M d, Y') ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @php
                            $colors = ['present' => 'bg-green-50 text-green-600', 'absent' => 'bg-red-50 text-red-600', 'late' => 'bg-amber-50 text-amber-600', 'excused' => 'bg-slate-100 text-slate-500'];
                        @endphp
                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $colors[$a->status] ?? 'bg-slate-100 text-slate-500' }}">{{ ucfirst($a->status) }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-5 py-8 text-center text-slate-400">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $attendances->links() }}</div>
@endsection