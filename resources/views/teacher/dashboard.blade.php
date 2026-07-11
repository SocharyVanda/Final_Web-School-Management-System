@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-1">Welcome back, {{ auth()->user()->name }}</h1>
<p class="text-sm text-slate-500 mb-6">Here's your teaching summary for today.</p>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">My Classes</p>
        <p class="text-2xl font-bold text-slate-800">{{ $classes->count() }}</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">My Subjects</p>
        <p class="text-2xl font-bold text-slate-800">{{ $subjects->count() }}</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">Students</p>
        <p class="text-2xl font-bold text-slate-800">{{ $studentCount }}</p>
    </div>
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">Pending Grades</p>
        <p class="text-2xl font-bold text-slate-800">{{ $pendingGrades }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-card shadow-soft p-6">
        <h2 class="font-semibold text-slate-800 mb-4">My Classes</h2>
        <table class="w-full text-sm">
            <thead class="text-slate-400 text-left"><tr><th class="py-2">Class</th><th>Students</th><th>Room</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($classes as $class)
                    <tr><td class="py-2">{{ $class->name }}</td><td>{{ $class->students_count }}</td><td>{{ $class->room ?? '—' }}</td></tr>
                @empty
                    <tr><td colspan="3" class="py-4 text-slate-400">No classes assigned yet.</td></tr>
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
