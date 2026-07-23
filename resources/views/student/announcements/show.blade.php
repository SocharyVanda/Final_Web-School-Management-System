@extends('layouts.app')
@section('title', $announcement->title)
@section('content')
<div class="w-full">
    <a href="{{ route('student.announcements.index') }}" class="text-sm text-slate-500 hover:underline">&larr; Back to Announcements</a>

    <div class="bg-white rounded-card shadow-soft p-8 mt-4 w-full">
        <div class="flex items-start justify-between">
            <h1 class="text-3xl font-bold text-slate-800 break-all">{{ $announcement->title }}</h1>
        </div>

        <p class="text-sm text-slate-400 mt-2">
            By {{ $announcement->author->name }} &middot; Target: {{ ucfirst($announcement->target_role) }}
            @if($announcement->schoolClass) &middot; {{ $announcement->schoolClass->name }} @endif
            &middot; {{ $announcement->created_at->diffForHumans() }}
        </p>

        <div class="prose prose-base max-w-none mt-6 text-slate-700 leading-relaxed break-all whitespace-normal" style="word-break: break-word; overflow-wrap: break-word;">
            {!! $announcement->description !!}
        </div>
    </div>
</div>
@endsection