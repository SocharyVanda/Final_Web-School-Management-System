<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher()->with(['subjects.schedules', 'subjects.schoolClass'])->first();

        $subjects = $teacher->subjects;
        $todayClassesCount = $subjects->count();
        $pendingGrades = \App\Models\Grade::whereIn('subject_id', $subjects->pluck('id'))
            ->where('approved', false)->count();

        // Build class cards from subjects + their schedules (room comes from schedule, not class)
        $teachingClasses = $subjects->map(function ($subject) {
            return [
                'name' => $subject->schoolClass?->name ?? 'Unknown Class',
                'room' => $subject->schedules->first()?->room ?? '—',
                'student_count' => $subject->schoolClass?->students_count ?? 0,
                'subject_name' => $subject->name,
            ];
        })->unique('name')->values();

        $studentCount = $teachingClasses->sum('student_count');

        // Flatten all schedule slots for the weekly grid
        $scheduleSlots = $subjects->flatMap(function ($subject) {
            return $subject->schedules->map(function ($slot) use ($subject) {
                return [
                    'subject_name' => $subject->name,
                    'subject_code' => $subject->code,
                    'teacher_name' => optional($subject->teacher?->user)->name,
                    'day_of_week' => $slot->day_of_week,
                    'start_time' => $slot->start_time,
                    'end_time' => $slot->end_time,
                    'room' => $slot->room,
                    'color' => $slot->color ?: '#2563EB',
                ];
            });
        });

        // Announcements - paginated, 4 per page, only all + teacher
        $announcements = Announcement::with('author')
            ->whereIn('target_role', ['all', 'teacher'])
            ->orderByDesc('created_at')
            ->paginate(4);

        return view('teacher.dashboard', compact(
            'teacher', 'teachingClasses', 'subjects', 'todayClassesCount',
            'pendingGrades', 'studentCount', 'announcements', 'scheduleSlots'
        ));
    }

    public function classes()
    {
        $teacher = Auth::user()->teacher()->with(['subjects.schedules', 'subjects.schoolClass'])->first();

        $teachingClasses = $teacher->subjects->map(function ($subject) {
            return [
                'name' => $subject->schoolClass?->name ?? 'Unknown Class',
                'room' => $subject->schedules->first()?->room ?? '—',
                'student_count' => $subject->schoolClass?->students()->count() ?? 0,
                'subject_name' => $subject->name,
            ];
        })->unique('name')->values();

        return view('teacher.classes.index', compact('teachingClasses'));
    }
}