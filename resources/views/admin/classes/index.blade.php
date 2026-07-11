@extends('layouts.app')
@section('title', 'Classes')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Classes</h1>
        <p class="text-sm text-slate-500">Manage classes, rooms, and homeroom teachers.</p>
    </div>
    <a href="{{ route('admin.classes.create') }}" class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium shadow-soft">+ Add Class</a>
</div>
<div class="bg-white rounded-card shadow-soft p-5 mb-4">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search classes..." class="flex-1 px-3 py-2 rounded-lg border border-slate-300 text-sm">
        <button class="px-4 py-2 rounded-lg bg-slate-100 text-sm font-medium">Search</button>
    </form>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($classes as $class)
        <div class="bg-white rounded-card shadow-soft p-5">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-slate-800">{{ $class->name }}</h3>
                <span class="text-xs text-slate-400">{{ $class->students_count }}/{{ $class->capacity }}</span>
            </div>
            <p class="text-sm text-slate-500 mb-1">Room: {{ $class->room ?? '—' }}</p>
            <p class="text-sm text-slate-500 mb-4">Homeroom: {{ $class->teacher->user->name ?? 'Unassigned' }}</p>
            <div class="flex gap-3 text-xs font-medium">
                <a href="{{ route('admin.classes.edit', $class) }}" class="text-brand hover:underline">Edit</a>
                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Delete this class?')">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:underline">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-slate-400 col-span-3 text-center py-8">No classes yet.</p>
    @endforelse
</div>
<div class="mt-4">{{ $classes->links() }}</div>
@endsection
