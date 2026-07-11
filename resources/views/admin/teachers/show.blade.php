@extends('layouts.app')
@section('title', 'Teacher Profile')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">{{ $teacher->user->name }}</h1>
    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Edit</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-card shadow-soft p-6">
        <h2 class="font-semibold text-slate-800 mb-3">Profile</h2>
        <dl class="space-y-2 text-sm">
            <div class="flex justify-between"><dt class="text-slate-500">Teacher ID</dt><dd class="font-medium">{{ $teacher->teacher_code }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Email</dt><dd class="font-medium">{{ $teacher->user->email }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Department</dt><dd class="font-medium">{{ $teacher->department ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Qualification</dt><dd class="font-medium">{{ $teacher->qualification ?? '—' }}</dd></div>
        </dl>
    </div>
    <div class="bg-white rounded-card shadow-soft p-6">
        <h2 class="font-semibold text-slate-800 mb-3">Assigned Classes & Subjects</h2>
        <p class="text-xs text-slate-400 mb-1">Classes</p>
        <p class="text-sm mb-3">{{ $teacher->classes->pluck('name')->join(', ') ?: '—' }}</p>
        <p class="text-xs text-slate-400 mb-1">Subjects</p>
        <p class="text-sm">{{ $teacher->subjects->pluck('name')->join(', ') ?: '—' }}</p>
    </div>
</div>
@endsection
