@extends('layouts.app')
@section('title', 'Announcements')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">Announcements</h1>
<div class="space-y-4">
    @forelse($announcements as $a)
        <a href="{{ route('student.announcements.show', $a) }}" class="block bg-white rounded-card shadow-soft p-5 hover:shadow-md transition-shadow">
            <h3 class="font-semibold text-slate-800">{{ $a->title }}</h3>
            <p class="text-sm text-slate-500 mt-1">
                {{ Str::limit(strip_tags($a->description), 120) }}
            </p>
            <p class="text-xs text-slate-400 mt-2">{{ $a->created_at->diffForHumans() }}</p>
        </a>
    @empty
        <p class="text-center text-slate-400 py-8">No announcements yet.</p>
    @endforelse
</div>
<div class="mt-4">{{ $announcements->links() }}</div>
@endsection