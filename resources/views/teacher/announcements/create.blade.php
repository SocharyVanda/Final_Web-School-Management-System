@extends('layouts.app')
@section('title', 'New Announcement')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">New Announcement</h1>
    <form method="POST" action="{{ route('teacher.announcements.store') }}" class="bg-white rounded-card shadow-soft p-6 space-y-5">
        @csrf
        <input type="hidden" name="target_role" value="student">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
            <input type="text" name="title" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
            <textarea name="description" rows="4" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Class</label>
            <select name="class_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                @foreach($classes as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-end gap-3">
            <a href="{{ route('teacher.announcements.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Post</button>
        </div>
    </form>
</div>
@endsection
