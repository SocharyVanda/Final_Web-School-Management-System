@extends('layouts.app')
@section('title', 'Announcements')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Announcements</h1>
        <p class="text-sm text-slate-500">Broadcast messages to staff and students.</p>
    </div>
    <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium shadow-soft">+ New Announcement</a>
</div>
<div class="space-y-4">
    @forelse($announcements as $a)
        <div class="relative bg-white rounded-card shadow-soft p-5 hover:shadow-md transition-shadow overflow-hidden">
            <a href="{{ route('admin.announcements.show', $a) }}" class="absolute inset-0 z-0" aria-label="View {{ $a->title }}"></a>

            <div class="flex items-start justify-between relative z-10 pointer-events-none">
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-slate-800">{{ $a->title }}</h3>
                    <div class="text-sm text-slate-500 mt-1 line-clamp-2 break-all">
                        {!! Str::limit(strip_tags($a->description, '<b><i><strong><em><u><s><span><a><br>'), 120) !!}
                    </div>
                    <p class="text-xs text-slate-400 mt-2">
                        By {{ $a->author->name }} · Target: {{ ucfirst($a->target_role) }}{{ $a->schoolClass ? ' · '.$a->schoolClass->name : '' }} · {{ $a->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="flex gap-3 text-xs font-medium shrink-0 ml-4 pointer-events-auto">
                    <a href="{{ route('admin.announcements.edit', $a) }}" class="text-brand hover:underline">Edit</a>
                    <form action="{{ route('admin.announcements.destroy', $a) }}" method="POST" onsubmit="return confirm('Delete this announcement?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-slate-400 py-8">No announcements yet.</p>
    @endforelse
</div>
<div class="mt-4">{{ $announcements->links() }}</div>
@endsection