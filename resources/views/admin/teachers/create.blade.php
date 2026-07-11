@extends('layouts.app')
@section('title', 'Add Teacher')
@section('content')
<div class="max-w-3xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-1">Add Teacher</h1>
    <p class="text-sm text-slate-500 mb-6">Create a new faculty account and assign login credentials.</p>
    <form method="POST" action="{{ route('admin.teachers.store') }}" enctype="multipart/form-data" class="bg-white rounded-card shadow-soft p-6 space-y-5">
        @csrf
        @include('admin.teachers._form', ['teacher' => null])
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium hover:bg-brand-dark">Create Teacher</button>
        </div>
    </form>
</div>
@endsection
