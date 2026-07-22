@extends('layouts.app')
@section('title', $announcement->title)
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('teacher.announcements.index') }}" class="text-sm text-slate-500 hover:underline">&larr; Back to Announcements</a>

    <div class="bg-white rounded-card shadow-soft p-6 mt-4">
        <div class="flex items-start justify-between">
            <h1 class="text-2xl font-bold text-slate-800">{{ $announcement->title }}</h1>
            @if($announcement->created_by === auth()->id())
                <form action="{{ route('teacher.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement?')">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                </form>
            @endif
        </div>

        <p class="text-xs text-slate-400 mt-1">
            Posted {{ $announcement->created_at->diffForHumans() }}
            @if($announcement->schoolClass) &middot; {{ $announcement->schoolClass->name }} @endif
        </p>

        <div class="prose prose-sm max-w-none mt-4 text-slate-700">
            {!! $announcement->description !!}
        </div>
    </div>
</div>
@endsection