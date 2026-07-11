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
}
