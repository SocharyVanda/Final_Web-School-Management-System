@extends('layouts.app')
@section('title', 'Settings')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">School Settings</h1>
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="bg-white rounded-card shadow-soft p-6 space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">School Name</label>
            <input type="text" name="school_name" value="{{ old('school_name', $setting->school_name) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Academic Year</label>
                <input type="text" name="academic_year" value="{{ old('academic_year', $setting->academic_year) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Semester</label>
                <input type="text" name="semester" value="{{ old('semester', $setting->semester) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
            <input type="file" name="logo" accept="image/*" class="w-full text-sm">
        </div>
        <div class="flex justify-end">
            <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Save Settings</button>
        </div>
    </form>
</div>
@endsection
