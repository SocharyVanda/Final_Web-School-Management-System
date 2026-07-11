@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">Reports</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <a href="{{ route('admin.reports.students') }}" class="bg-white rounded-card shadow-soft p-5 hover:shadow-md transition">
        <h3 class="font-semibold text-slate-800 mb-1">Student List</h3>
        <p class="text-sm text-slate-500">Download the full student roster as PDF.</p>
    </a>
    <a href="{{ route('admin.reports.teachers') }}" class="bg-white rounded-card shadow-soft p-5 hover:shadow-md transition">
        <h3 class="font-semibold text-slate-800 mb-1">Teacher List</h3>
        <p class="text-sm text-slate-500">Download the full faculty roster as PDF.</p>
    </a>
    <a href="{{ route('admin.attendance.index') }}" class="bg-white rounded-card shadow-soft p-5 hover:shadow-md transition">
        <h3 class="font-semibold text-slate-800 mb-1">Attendance Report</h3>
        <p class="text-sm text-slate-500">View and export attendance records.</p>
    </a>
    <a href="{{ route('admin.reports.grades') }}" class="bg-white rounded-card shadow-soft p-5 hover:shadow-md transition">
        <h3 class="font-semibold text-slate-800 mb-1">Grade Report</h3>
        <p class="text-sm text-slate-500">Download all approved and pending grades.</p>
    </a>
</div>
@endsection
