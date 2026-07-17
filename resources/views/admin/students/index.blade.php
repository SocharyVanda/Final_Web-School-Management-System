@extends('layouts.app')
@section('title', 'Students')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Students</h1>
        <p class="text-sm text-slate-500">Manage all student accounts and records.</p>
    </div>
    <a href="{{ route('admin.students.create') }}" class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium shadow-soft hover:bg-brand-dark">+ Add Student</a>
</div>

<div class="bg-white rounded-card shadow-soft p-5 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or ID..."
            class="flex-1 min-w-[220px] px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-brand outline-none">
        <select name="class_id" class="px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">All Classes</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2 rounded-lg bg-slate-100 text-sm font-medium hover:bg-slate-200">Filter</button>
    </form>
</div>

<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr>
                <th class="px-5 py-3 font-medium">Student</th>
                <th class="px-5 py-3 font-medium">Student ID</th>
                <th class="px-5 py-3 font-medium">Class</th>
                <th class="px-5 py-3 font-medium">Status</th>
                <th class="px-5 py-3 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($students as $student)
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            @if($student->user?->photo)
                                <img src="{{ asset('storage/' . $student->user->photo) }}" alt="Profile"
                                    class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-brand flex items-center justify-center font-semibold text-xs">
                                    {{ strtoupper(substr($student->user?->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-slate-800">{{ $student->user?->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-slate-400">{{ $student->user?->email ?? '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-slate-600">{{ $student->student_code }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $student->schoolClass->name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ ($student->user?->status ?? 'inactive') === 'active' ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                            {{ ucfirst($student->user?->status ?? 'inactive') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right space-x-2">
                        <a href="{{ route('admin.students.show', $student) }}" class="text-slate-500 hover:text-brand text-xs font-medium">View</a>
                        <a href="{{ route('admin.students.edit', $student) }}" class="text-brand hover:underline text-xs font-medium">Edit</a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Delete this student?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">No students found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $students->links() }}</div>
@endsection