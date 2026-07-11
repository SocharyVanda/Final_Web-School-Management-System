@extends('layouts.app')
@section('title', 'Edit Announcement')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Announcement</h1>
    <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" class="bg-white rounded-card shadow-soft p-6 space-y-5">
        @csrf @method('PUT')
        @include('admin.announcements._form', ['announcement' => $announcement])
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Save Changes</button>
        </div>
    </form>
</div>
@endsection
