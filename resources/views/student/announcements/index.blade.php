@extends('layouts.app')
@section('title', 'Announcements')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Announcements</h1>
        <p class="text-sm text-slate-500">View announcements for students.</p>
    </div>
</div>
<div class="space-y-4">
    @forelse($announcements as $a)
        <a href="{{ route('student.announcements.show', $a) }}" class="block bg-white rounded-card shadow-soft p-5 hover:shadow-md transition-shadow border-l-4 border-brand overflow-hidden">
            <h3 class="font-semibold text-slate-800">{{ $a->title }}</h3>
            <div class="text-sm text-slate-500 mt-1 line-clamp-2 break-all">
                {!! Str::limit(strip_tags($a->description, '<b><i><strong><em><u><s><span><a><br>'), 120) !!}
            </div>
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