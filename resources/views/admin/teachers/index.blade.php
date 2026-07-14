@extends('layouts.app')
@section('title', 'Teachers')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Teachers</h1>
        <p class="text-sm text-slate-500">Manage faculty accounts and assignments.</p>
    </div>
    <a href="{{ route('admin.teachers.create') }}" class="px-4 py-2 rounded-lg bg-brand text-white text-sm font-medium shadow-soft hover:bg-brand-dark">+ Add Teacher</a>
</div>

<div class="bg-white rounded-card shadow-soft p-5 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or ID..."
            class="flex-1 min-w-[220px] px-3 py-2 rounded-lg border border-slate-300 text-sm">
        <button class="px-4 py-2 rounded-lg bg-slate-100 text-sm font-medium hover:bg-slate-200">Search</button>
    </form>
</div>

<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left">
            <tr>
                <th class="px-5 py-3 font-medium">Teacher</th>
                <th class="px-5 py-3 font-medium">Teacher ID</th>
                <th class="px-5 py-3 font-medium">Department</th>
                <th class="px-5 py-3 font-medium">Status</th>
                <th class="px-5 py-3 font-medium text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($teachers as $teacher)
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3">
                        <p class="font-medium text-slate-800">{{ $teacher->user->name }}</p>
                        <p class="text-xs text-slate-400">{{ $teacher->user->email }}</p>
                    </td>
                    <td class="px-5 py-3 text-slate-600">{{ $teacher->teacher_code }}</td>
                    <td class="px-5 py-3 text-slate-600">{{ $teacher->department ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $teacher->user->status === 'active' ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                            {{ ucfirst($teacher->user->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right space-x-2">
                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="text-slate-500 hover:text-brand text-xs font-medium">View</a>
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-brand hover:underline text-xs font-medium">Edit</a>
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline" onsubmit="return confirm('Delete this teacher?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-xs font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">No teachers found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $teachers->links() }}</div>
@endsection