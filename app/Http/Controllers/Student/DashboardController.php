<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student()->with('schoolClass.subjects.schedules', 'schoolClass.subjects.teacher.user', 'grades.subject')->first();

        $attendancePercentage = $student->attendancePercentage();
        $gpa = $student->gpa();
        $enrolledSubjects = $student->schoolClass?->subjects ?? collect();
        $recentGrades = $student->grades()->with('subject')->latest()->take(5)->get();

        // Announcements - paginated, 4 per page, only all + student (filtered by class if applicable)
        $announcements = Announcement::with('author')
            ->whereIn('target_role', ['all', 'student'])
            ->where(function ($q) use ($student) {
                $q->whereNull('class_id')->orWhere('class_id', $student->class_id);
            })
            ->orderByDesc('created_at')
            ->paginate(4);

        // Flatten all schedule slots from class subjects for the weekly grid
        $scheduleSlots = $enrolledSubjects->flatMap(function ($subject) {
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

        return view('student.dashboard', compact(
            'student', 'attendancePercentage', 'gpa', 'enrolledSubjects', 'recentGrades', 'announcements', 'scheduleSlots'
        ));
    }
}