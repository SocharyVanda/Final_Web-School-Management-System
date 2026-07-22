@extends('layouts.app')
@section('title', 'Student Dashboard')
@section('content')
<x-schedule :schedules="collect($scheduleSlots)" />
<h1 class="text-2xl font-bold text-slate-800 mb-1">Welcome back, {{ auth()->user()->name }}</h1>
<p class="text-sm text-slate-500 mb-6">Class: {{ $student->schoolClass->name ?? 'Unassigned' }}</p>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">My Attendance</p>
        <p class="text-2xl font-bold text-slate-800">{{ $attendancePercentage }}%</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">Current GPA</p>
        <p class="text-2xl font-bold text-slate-800">{{ $gpa }}</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">Enrolled Subjects</p>
        <p class="text-2xl font-bold text-slate-800">{{ $enrolledSubjects->count() }}</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">Announcements</p>
        <p class="text-2xl font-bold text-slate-800">{{ $announcements->total() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 bg-white rounded-card shadow-soft p-6">
        <h2 class="font-semibold text-slate-800 mb-4">Recent Grades</h2>
        <table class="w-full text-sm">
            <thead class="text-slate-400 text-left"><tr><th class="py-2">Subject</th><th>Average</th><th>Grade</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($recentGrades as $grade)
                    <tr><td class="py-2">{{ $grade->subject?->name ?? '—' }}</td><td>{{ $grade->average }}</td><td>{{ $grade->grade }}</td></tr>
                @empty
                    <tr><td colspan="3" class="py-4 text-slate-400">No grades yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="bg-white rounded-card shadow-soft p-6">
        <h2 class="font-semibold text-slate-800 mb-4">Announcements</h2>
        <div class="space-y-3">
            @forelse($announcements as $a)
                <div>
                    <p class="text-sm font-medium text-slate-700">{{ $a->title }}</p>
                    <p class="text-xs text-slate-400">{{ $a->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-400">No announcements.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="bg-white rounded-card shadow-soft p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold text-slate-800">Announcements</h2>
    </div>
    <div class="space-y-4">
        @forelse($announcements as $a)
            <div class="border-l-4 border-brand pl-4 py-1">
                <p class="text-sm font-medium text-slate-800">{{ $a->title }}</p>
                <p class="text-xs text-slate-500 mt-0.5">{!! Str::limit(strip_tags($a->description), 120) !!}</p>
                <p class="text-xs text-slate-400 mt-1">
                    By {{ $a->author?->name ?? 'Unknown' }} · {{ $a->created_at->diffForHumans() }}
                    @if($a->target_role)
                        · Target: {{ ucfirst($a->target_role) }}
                    @endif
                </p>
            </div>
        @empty
            <p class="text-sm text-slate-400">No announcements yet.</p>
        @endforelse
    </div>

    @if($announcements->hasPages())
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
            <div class="text-xs text-slate-400">
                Showing {{ $announcements->firstItem() }}–{{ $announcements->lastItem() }} of {{ $announcements->total() }}
            </div>
            <div class="flex gap-2">
                @if($announcements->onFirstPage())
                    <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-400 text-xs font-medium cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $announcements->previousPageUrl() }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-medium transition">Previous</a>
                @endif
                @if($announcements->hasMorePages())
                    <a href="{{ $announcements->nextPageUrl() }}" class="px-3 py-1 rounded-lg bg-brand hover:bg-brand-dark text-white text-xs font-medium transition">Next</a>
                @else
                    <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-400 text-xs font-medium cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection