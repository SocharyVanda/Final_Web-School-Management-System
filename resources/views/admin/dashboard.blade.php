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

<div class="bg-white rounded-card shadow-soft p-4 mb-4 flex items-center gap-3">
    <label class="text-sm font-medium text-slate-600">
        View Class:
    </label>

    <form method="GET">
        <select
            name="class_id"
            onchange="this.form.submit()"
            class="px-3 py-2 rounded-lg border border-slate-300 text-sm"
        >
            @foreach($classes as $class)
                <option
                    value="{{ $class->id }}"
                    @selected($class->id == $selectedClassId)
                >
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<x-schedule :schedules="$schedules" />

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

        @php
            $max = max($months->max('count'), 1);
            $chartWidth = 600;
            $chartHeight = 180;
            $padding = 20;
            $stepX = $months->count() > 1 ? ($chartWidth - $padding * 2) / ($months->count() - 1) : 0;

            $points = $months->values()->map(function ($m, $i) use ($stepX, $padding, $chartHeight, $max) {
                $x = $padding + ($i * $stepX);
                $y = $chartHeight - (($m['count'] / $max) * ($chartHeight - $padding));
                return ['x' => $x, 'y' => $y, 'count' => $m['count'], 'label' => $m['label']];
            });

            $polylinePoints = $points->map(fn ($p) => "{$p['x']},{$p['y']}")->implode(' ');
        @endphp

        <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight + 30 }}" class="w-full h-56">
            @for($i = 0; $i <= 4; $i++)
                <line x1="0" y1="{{ $i * ($chartHeight / 4) }}" x2="{{ $chartWidth }}" y2="{{ $i * ($chartHeight / 4) }}"
                      stroke="#F1F5F9" stroke-width="1"/>
            @endfor

            <polyline points="{{ $polylinePoints }}" fill="none" stroke="#2563EB" stroke-width="2.5"
                      stroke-linecap="round" stroke-linejoin="round"/>

            @foreach($points as $p)
                <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="4" fill="#2563EB" stroke="white" stroke-width="2"/>
                <text x="{{ $p['x'] }}" y="{{ $chartHeight + 20 }}" font-size="11" fill="#94A3B8" text-anchor="middle">
                    {{ $p['label'] }}
                </text>
                <text x="{{ $p['x'] }}" y="{{ $p['y'] - 10 }}" font-size="10" fill="#334155" text-anchor="middle" font-weight="600">
                    {{ $p['count'] }}
                </text>
            @endforeach
        </svg>
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

<div class="bg-white rounded-card shadow-soft p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold text-slate-800">Announcements</h2>
        <a href="{{ route('admin.announcements.index') }}" class="text-sm text-brand hover:underline">View All</a>
    </div>
    <div class="space-y-4">
        @forelse($announcements as $a)
            <a href="{{ route('admin.announcements.show', $a) }}" class="block border-l-4 border-brand pl-4 py-1 hover:bg-slate-50 rounded-r-lg transition-colors overflow-hidden">
                <p class="text-sm font-medium text-slate-800">{{ $a->title }}</p>
                <div class="text-xs text-slate-500 mt-0.5 line-clamp-2 break-all">
                    {!! Str::limit(strip_tags($a->description, '<b><i><strong><em><u><s><span><a><br>'), 120) !!}
                </div>
                <p class="text-xs text-slate-400 mt-1">
                    By {{ $a->author?->name ?? 'Unknown' }} · {{ $a->created_at->diffForHumans() }}
                    @if($a->target_role)
                        · Target: {{ ucfirst($a->target_role) }}
                    @endif
                </p>
            </a>
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