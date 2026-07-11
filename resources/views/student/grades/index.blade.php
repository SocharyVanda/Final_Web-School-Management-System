@extends('layouts.app')
@section('title', 'My Grades')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">My Grades</h1>
<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left"><tr><th class="px-5 py-3 font-medium">Subject</th><th class="px-5 py-3 font-medium">Assignment</th><th class="px-5 py-3 font-medium">Quiz</th><th class="px-5 py-3 font-medium">Midterm</th><th class="px-5 py-3 font-medium">Final</th><th class="px-5 py-3 font-medium">Average</th><th class="px-5 py-3 font-medium">Grade</th></tr></thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($grades as $g)
                <tr>
                    <td class="px-5 py-3">{{ $g->subject->name }}</td>
                    <td class="px-5 py-3">{{ $g->assignment }}</td>
                    <td class="px-5 py-3">{{ $g->quiz }}</td>
                    <td class="px-5 py-3">{{ $g->midterm }}</td>
                    <td class="px-5 py-3">{{ $g->final }}</td>
                    <td class="px-5 py-3 font-medium">{{ $g->average }}</td>
                    <td class="px-5 py-3 font-semibold">{{ $g->grade }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-5 py-8 text-center text-slate-400">No grades recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
