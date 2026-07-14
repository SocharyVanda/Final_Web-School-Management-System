@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-1">Welcome back, {{ auth()->user()->name }}</h1>
<p class="text-sm text-slate-500 mb-6">Here's your teaching summary for today.</p>

<x-schedule :schedules="collect($scheduleSlots)" />

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-card shadow-soft p-5">
        <p class="text-xs font-medium text-slate-400 uppercase">My Classes</p>
        <p class="text-2xl font-bold text-slate-800">{{ $teachingClasses->count() }}</p>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($teachingClasses as $class)
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="font-semibold text-slate-800">{{ $class['name'] }}</p>
                    <p class="text-sm text-slate-500">Room: {{ $class['room'] }}</p>
                    <p class="text-sm text-slate-500">Students: {{ $class['student_count'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $class['subject_name'] }}</p>
                </div>
            @empty
                <p class="text-slate-400 col-span-2">No classes assigned yet.</p>
            @endforelse
        </div>
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