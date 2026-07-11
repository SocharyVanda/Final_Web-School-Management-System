@extends('layouts.app')
@section('title', 'Course Materials')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">Course Materials</h1>
<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left"><tr><th class="px-5 py-3 font-medium">Title</th><th class="px-5 py-3 font-medium">Subject</th><th class="px-5 py-3 font-medium text-right">Action</th></tr></thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($materials as $m)
                <tr>
                    <td class="px-5 py-3">{{ $m->title }}</td>
                    <td class="px-5 py-3">{{ $m->subject->name }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('student.materials.download', $m) }}" class="text-brand hover:underline text-xs font-medium">Download</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-5 py-8 text-center text-slate-400">No materials available yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
