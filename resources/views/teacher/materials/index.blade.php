@extends('layouts.app')
@section('title', 'Course Materials')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">Course Materials</h1>

<div class="bg-white rounded-card shadow-soft p-6 mb-6">
    <h2 class="font-semibold text-slate-800 mb-4">Upload New Material</h2>
    <form method="POST" action="{{ route('teacher.materials.store') }}" enctype="multipart/form-data" class="flex flex-wrap gap-3 items-end">
        @csrf
        <div class="flex-1 min-w-[160px]">
            <label class="block text-xs font-medium text-slate-500 mb-1">Subject</label>
            <select name="subject_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[160px]">
            <label class="block text-xs font-medium text-slate-500 mb-1">Title</label>
            <input type="text" name="title" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">File</label>
            <input type="file" name="file" required class="text-sm">
        </div>
        <button class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium">Upload</button>
    </form>
</div>

<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left"><tr><th class="px-5 py-3 font-medium">Title</th><th class="px-5 py-3 font-medium">Subject</th><th class="px-5 py-3 font-medium">Uploaded</th><th class="px-5 py-3 font-medium text-right">Actions</th></tr></thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($materials as $m)
                <tr>
                    <td class="px-5 py-3">{{ $m->title }}</td>
                    <td class="px-5 py-3">{{ $m->subject->name }}</td>
                    <td class="px-5 py-3">{{ $m->created_at->diffForHumans() }}</td>
                    <td class="px-5 py-3 text-right">
                        <form action="{{ route('teacher.materials.destroy', $m) }}" method="POST" onsubmit="return confirm('Remove this material?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-5 py-8 text-center text-slate-400">No materials uploaded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
