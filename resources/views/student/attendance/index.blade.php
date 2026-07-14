@extends('layouts.app')
@section('title', 'My Attendance')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">My Attendance</h1>
<div class="bg-white rounded-card shadow-soft overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-left"><tr><th class="px-5 py-3 font-medium">Date</th><th class="px-5 py-3 font-medium">Subject</th><th class="px-5 py-3 font-medium">Status</th></tr></thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($attendances as $a)
                <tr>
                    <td class="px-5 py-3">{{ $a->date?->format('M d, Y') ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $a->subject?->name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        @php $colors = ['present' => 'bg-green-50 text-green-600', 'absent' => 'bg-red-50 text-red-600', 'late' => 'bg-amber-50 text-amber-600', 'excused' => 'bg-slate-100 text-slate-500']; @endphp
                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $colors[$a->status] ?? 'bg-slate-100 text-slate-500' }}">{{ ucfirst($a->status) }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-5 py-8 text-center text-slate-400">No attendance recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $attendances->links() }}</div>
@endsection