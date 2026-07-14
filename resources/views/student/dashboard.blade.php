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
        <p class="text-2xl font-bold text-slate-800">{{ $announcements->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
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
@endsection
