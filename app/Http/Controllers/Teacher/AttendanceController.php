<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $subjects = $teacher->subjects()->with('schoolClass')->get();

        $subjectId = $request->get('subject_id', $subjects->first()->id ?? null);
        $date = $request->get('date', now()->toDateString());

        $students = collect();
        $existing = collect();

        if ($subjectId) {
            $subject = Subject::with('schoolClass.students.user')->findOrFail($subjectId);
            abort_unless($subject->teacher_id === $teacher->id, 403);

            $students = $subject->schoolClass->students ?? collect();
            $existing = Attendance::where('subject_id', $subjectId)
                ->whereDate('date', $date)->get()->keyBy('student_id');
        }

        return view('teacher.attendance.index', compact('subjects', 'subjectId', 'date', 'students', 'existing'));
    }

    public function store(AttendanceRequest $request)
    {
        $teacher = Auth::user()->teacher;
        $subject = Subject::findOrFail($request->subject_id);
        abort_unless($subject->teacher_id === $teacher->id, 403);

        foreach ($request->statuses as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'date' => $request->date,
                ],
                ['status' => $status, 'teacher_id' => $teacher->id]
            );
        }

        return back()->with('success', 'Attendance submitted successfully.');
    }
}
