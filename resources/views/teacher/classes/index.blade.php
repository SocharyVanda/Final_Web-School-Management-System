@extends('layouts.app')
@section('title', 'My Classes')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">My Classes</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($teachingClasses as $class)
        <div class="bg-white rounded-card shadow-soft p-5">
            <p class="font-semibold text-slate-800 text-lg">{{ $class['name'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Room: {{ $class['room'] }}</p>
            <p class="text-sm text-slate-500">Students: {{ $class['student_count'] }}</p>
            <p class="text-xs text-slate-400 mt-2">{{ $class['subject_name'] }}</p>
        </div>
    @empty
        <p class="text-slate-400 col-span-3">No classes assigned yet.</p>
    @endforelse
</div>
@endsection