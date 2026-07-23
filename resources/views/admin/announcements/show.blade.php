@extends('layouts.app')
@section('title', $announcement->title)
@section('content')
<div class="w-full">
    <a href="{{ route('admin.announcements.index') }}" class="text-sm text-slate-500 hover:underline">&larr; Back to Announcements</a>

    <div class="bg-white rounded-card shadow-soft p-8 mt-4 w-full">
        <div class="flex items-start justify-between">
            <h1 class="text-3xl font-bold text-slate-800 break-all">{{ $announcement->title }}</h1>
            <div class="flex gap-3 text-xs font-medium shrink-0 ml-4">
                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-brand hover:underline">Edit</a>
                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement?')">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:underline">Delete</button>
                </form>
            </div>
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