@extends('layouts.app')
@section('title', 'Settings')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">School Settings</h1>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="bg-white rounded-card shadow-soft p-6 space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">School Name</label>
            <input type="text" name="school_name" value="{{ old('school_name', $setting->school_name) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            @error('school_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Academic Year</label>
                <input type="text" name="academic_year" value="{{ old('academic_year', $setting->academic_year) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                @error('academic_year')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Semester</label>
                <input type="text" name="semester" value="{{ old('semester', $setting->semester) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                @error('semester')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
            @if($setting->logo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Current logo" class="h-16 w-auto rounded border border-slate-200">
                </div>
            @endif
            <input type="file" name="logo" accept="image/*" class="w-full text-sm">
            @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex justify-end">
            <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Save Settings</button>
        </div>
    </form>
</div>
@endsection