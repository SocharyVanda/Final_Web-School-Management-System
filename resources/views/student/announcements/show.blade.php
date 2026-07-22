@extends('layouts.app')
@section('title', $announcement->title)
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('student.announcements.index') }}" class="text-sm text-slate-500 hover:underline">&larr; Back to Announcements</a>

    <div class="bg-white rounded-card shadow-soft p-6 mt-4">
        <h1 class="text-2xl font-bold text-slate-800">{{ $announcement->title }}</h1>
        <p class="text-xs text-slate-400 mt-1">
            {{ $announcement->created_at->diffForHumans() }}
        </p>

        <div class="prose prose-sm max-w-none mt-4 text-slate-700">
            {!! $announcement->description !!}
        </div>
    </div>
</div>
@endsection