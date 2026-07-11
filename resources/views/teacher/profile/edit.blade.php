@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">My Profile</h1>
    <form method="POST" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data" class="bg-white rounded-card shadow-soft p-6 space-y-5">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-5 text-sm text-slate-500">
            <div><p class="text-xs uppercase">Employee ID</p><p class="font-medium text-slate-800">{{ $teacher->teacher_code }}</p></div>
            <div><p class="text-xs uppercase">Department</p><p class="font-medium text-slate-800">{{ $teacher->department ?? '—' }}</p></div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
            <input type="text" name="address" value="{{ old('address', $teacher->address) }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">New Password (optional)</label>
            <input type="password" name="password" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Profile Picture</label>
            <input type="file" name="photo" accept="image/*" class="w-full text-sm">
        </div>
        <div class="flex justify-end">
            <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Save Changes</button>
        </div>
    </form>
</div>
@endsection
