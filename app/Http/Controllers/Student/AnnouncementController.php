<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $announcements = Announcement::whereIn('target_role', ['all', 'student'])
            ->where(function ($q) use ($student) {
                $q->whereNull('class_id')->orWhere('class_id', $student->class_id);
            })
            ->orderByDesc('created_at')->paginate(10);

        return view('student.announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        $student = Auth::user()->student;

        $visible = in_array($announcement->target_role, ['all', 'student'])
            && ($announcement->class_id === null || $announcement->class_id === $student->class_id);

        abort_unless($visible, 403);

        return view('student.announcements.show', compact('announcement'));
    }
}