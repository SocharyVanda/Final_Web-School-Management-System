@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Academy Overview</h1>
        <p class="text-sm text-slate-500">Welcome back, {{ auth()->user()->name }}. Here is what's happening today.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 rounded-lg bg-white border border-slate-200 text-sm font-medium shadow-soft hover:bg-slate-50">Export Data</a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-card shadow-soft p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-brand">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Students</p>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($totalStudents) }}</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-brand">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m-9-3v3l9 4 9-4v-3"/></svg>
            </div>
        </div>
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Teachers</p>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($totalTeachers) }}</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-brand">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Attendance Today</p>
        <p class="text-2xl font-bold text-slate-800">{{ $todayAttendanceRate }}%</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-brand">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21h2m0 0h10M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 6v-3a1 1 0 011-1h0a1 1 0 011 1v3"/></svg>
            </div>
            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">{{ $activeClassesPercent }}% Cap</span>
        </div>
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Active Classes</p>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($totalClasses) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 bg-white rounded-card shadow-soft p-6">
        <h2 class="font-semibold text-slate-800 mb-1">Student Enrollment</h2>
        <p class="text-sm text-slate-500 mb-4">Registration trends over the last 6 months</p>
        <div class="flex items-end gap-4 h-48">
            @php $max = max($months->max('count'), 1); @endphp
            @foreach($months as $m)
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-blue-100 rounded-t-lg relative" style="height: {{ max(($m['count'] / $max) * 100, 4) }}%">
                        <div class="absolute inset-0 bg-brand rounded-t-lg opacity-80"></div>
                    </div>
                    <span class="text-xs text-slate-400">{{ $m['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-card shadow-soft p-6">
        <h2 class="font-semibold text-slate-800 mb-4">Recent Activity</h2>
        <div class="space-y-4">
            @forelse($recentActivity as $activity)
                <div class="flex gap-3">
                    <div class="w-2 h-2 mt-1.5 rounded-full bg-brand shrink-0"></div>
                    <div>
                        <p class="text-sm text-slate-700">{{ $activity['text'] }}</p>
                        <p class="text-xs text-slate-400">{{ \Illuminate\Support\Carbon::parse($activity['time'])->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-400">No recent activity yet.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="bg-white rounded-card shadow-soft p-6">
    <h2 class="font-semibold text-slate-800 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('admin.students.create') }}" class="rounded-lg bg-blue-50 hover:bg-blue-100 text-center p-5 transition">
            <p class="text-sm font-semibold text-slate-700">Add Student</p>
        </a>
        <a href="{{ route('admin.classes.create') }}" class="rounded-lg bg-blue-50 hover:bg-blue-100 text-center p-5 transition">
            <p class="text-sm font-semibold text-slate-700">Create Class</p>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="rounded-lg bg-blue-50 hover:bg-blue-100 text-center p-5 transition">
            <p class="text-sm font-semibold text-slate-700">Generate Report</p>
        </a>
        <a href="{{ route('admin.announcements.create') }}" class="rounded-lg bg-blue-50 hover:bg-blue-100 text-center p-5 transition">
            <p class="text-sm font-semibold text-slate-700">Broadcast Email</p>
        </a>
    </div>
</div>
@endsection
