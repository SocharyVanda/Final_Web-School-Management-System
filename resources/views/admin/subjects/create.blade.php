@extends('layouts.app')
@section('title', 'Add Subject')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Add Subject</h1>
    <form method="POST" action="{{ route('admin.subjects.store') }}" class="bg-white rounded-card shadow-soft p-6 space-y-5">
        @csrf
        @include('admin.subjects._form', ['subject' => null])
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-100">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Create Subject</button>
        </div>
    </form>
</div>
@endsection
