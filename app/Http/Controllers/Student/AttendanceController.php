<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        $attendances = $student->attendances()->with('subject')->orderByDesc('date')->paginate(20);

        return view('student.attendance.index', compact('attendances'));
    }
}
