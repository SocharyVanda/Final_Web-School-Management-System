<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student()->with('schoolClass', 'subjects', 'grades.subject')->first();

        $attendancePercentage = $student->attendancePercentage();
        $gpa = $student->gpa();
        $enrolledSubjects = $student->subjects;
        $recentGrades = $student->grades()->with('subject')->latest()->take(5)->get();

        $announcements = Announcement::whereIn('target_role', ['all', 'student'])
            ->where(function ($q) use ($student) {
                $q->whereNull('class_id')->orWhere('class_id', $student->class_id);
            })
            ->orderByDesc('created_at')->take(5)->get();

        return view('student.dashboard', compact(
            'student', 'attendancePercentage', 'gpa', 'enrolledSubjects', 'recentGrades', 'announcements'
        ));
    }
}
