@extends('layouts.app')
@section('title', 'Edit Teacher')
@section('content')
<div class="max-w-3xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-1">Edit Teacher</h1>
    <p class="text-sm text-slate-500 mb-6">Update {{ $teacher->user->name }}'s record.</p>
    <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" enctype="multipart/form-data" class="bg-white rounded-card shadow-soft p-6 space-y-5">
        @csrf @method('PUT')
        @include('admin.teachers._form', ['teacher' => $teacher])
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium hover:bg-brand-dark">Save Changes</button>
        </div>
    </form>

    <div class="bg-white rounded-card shadow-soft p-6 mt-6">
        <h2 class="font-semibold text-slate-800 mb-3">Reset Password</h2>
        <form method="POST" action="{{ route('admin.teachers.reset-password', $teacher) }}" class="flex gap-3">
            @csrf
            <input type="password" name="password" required placeholder="New password" class="flex-1 px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <button class="px-4 py-2 rounded-lg bg-slate-800 text-white text-sm font-medium">Reset</button>
        </form>
    </div>
</div>
@endsection
