@extends('layouts.app')
@section('title', 'Announcements')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Announcements</h1>
        <p class="text-sm text-slate-500">View announcements for teachers.</p>
    </div>
</div>
<div class="space-y-4">
    @forelse($announcements as $a)
        <a href="{{ route('teacher.announcements.show', $a) }}" class="block bg-white rounded-card shadow-soft p-5 hover:shadow-md transition-shadow border-l-4 border-brand">
            <h3 class="font-semibold text-slate-800">{{ $a->title }}</h3>
            <p class="text-sm text-slate-500 mt-1">
                {{ Str::limit(strip_tags($a->description), 120) }}
            </p>
            <p class="text-xs text-slate-400 mt-2">
                By {{ $a->author->name }} · Target: {{ ucfirst($a->target_role) }}{{ $a->schoolClass ? ' · '.$a->schoolClass->name : '' }} · {{ $a->created_at->diffForHumans() }}
            </p>
        </a>
    @empty
        <p class="text-center text-slate-400 py-8">No announcements yet.</p>
    @endforelse
</div>
<div class="mt-4">{{ $announcements->links() }}</div>
@endsection