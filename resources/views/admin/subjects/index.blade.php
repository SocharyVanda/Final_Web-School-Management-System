@extends('layouts.app')
@section('title', 'Subjects')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Subjects</h1>
        <p class="text-sm text-slate-500">Manage subjects and teacher assignments.</p>
    </div>
    <a href="{{ route('admin.subjects.create') }}" class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium shadow-soft">+ Add Subject</a>
</div>
<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr><th class="px-5 py-3 font-medium">Subject</th><th class="px-5 py-3 font-medium">Code</th><th class="px-5 py-3 font-medium">Teacher</th><th class="px-5 py-3 font-medium">Class</th><th class="px-5 py-3 font-medium text-right">Actions</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($subjects as $subject)
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3 font-medium text-slate-800">{{ $subject->name }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $subject->code }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $subject->teacher->user->name ?? 'Unassigned' }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $subject->schoolClass->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-right space-x-2">
                        <a href="{{ route('admin.subjects.edit', $subject) }}" class="text-brand hover:underline text-xs font-medium">Edit</a>
                        <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="inline" onsubmit="return confirm('Delete this subject?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">No subjects found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $subjects->links() }}</div>
@endsection
