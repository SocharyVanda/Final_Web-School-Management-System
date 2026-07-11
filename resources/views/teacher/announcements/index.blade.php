@extends('layouts.app')
@section('title', 'Announcements')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Announcements</h1>
    <a href="{{ route('teacher.announcements.create') }}" class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">+ New</a>
</div>
<div class="space-y-4">
    @forelse($announcements as $a)
        <div class="bg-white rounded-card shadow-soft p-5">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-semibold text-slate-800">{{ $a->title }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $a->description }}</p>
                    <p class="text-xs text-slate-400 mt-2">{{ $a->created_at->diffForHumans() }}</p>
                </div>
                @if($a->created_by === auth()->id())
                    <form action="{{ route('teacher.announcements.destroy', $a) }}" method="POST" onsubmit="return confirm('Delete this announcement?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-center text-slate-400 py-8">No announcements yet.</p>
    @endforelse
</div>
<div class="mt-4">{{ $announcements->links() }}</div>
@endsection
