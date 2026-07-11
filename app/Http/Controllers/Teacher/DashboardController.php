<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        $classes = $teacher->classes()->withCount('students')->get();
        $subjects = $teacher->subjects()->with('schoolClass')->get();
        $todayClassesCount = $subjects->count();
        $pendingGrades = \App\Models\Grade::whereIn('subject_id', $subjects->pluck('id'))
            ->where('approved', false)->count();
        $studentCount = \App\Models\Student::whereIn('class_id', $classes->pluck('id'))->count();

        $announcements = \App\Models\Announcement::whereIn('target_role', ['all', 'teacher'])
            ->orderByDesc('created_at')->take(5)->get();

        return view('teacher.dashboard', compact(
            'teacher', 'classes', 'subjects', 'todayClassesCount',
            'pendingGrades', 'studentCount', 'announcements'
        ));
    }

    public function classes()
    {
        $teacher = Auth::user()->teacher;
        $classes = $teacher->classes()->withCount('students')->get();
        return view('teacher.classes.index', compact('classes'));
    }
}
