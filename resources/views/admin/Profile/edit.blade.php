@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <div class="max-w-2xl">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">My Profile</h1>
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data"
            class="bg-white rounded-card shadow-soft p-6 space-y-5">
            @csrf @method('PUT')

            <div class="flex items-center gap-4">
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile photo"
                        class="w-16 h-16 rounded-full object-cover">
                @else
                    <div
                        class="w-16 h-16 rounded-full bg-brand text-white flex items-center justify-center font-semibold text-xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                    <p class="text-xs text-slate-400 uppercase">{{ $user->role }}</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="text" value="{{ $user->email }}" disabled
                    class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">New Password (optional)</label>
                <input type="password" name="password" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
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
