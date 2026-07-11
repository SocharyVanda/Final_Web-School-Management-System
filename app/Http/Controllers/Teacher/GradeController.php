<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $subjects = $teacher->subjects()->with('schoolClass')->get();

        $subjectId = $request->get('subject_id', $subjects->first()->id ?? null);
        $grades = collect();

        if ($subjectId) {
            $subject = Subject::with('students.user')->findOrFail($subjectId);
            abort_unless($subject->teacher_id === $teacher->id, 403);

            foreach ($subject->students as $student) {
                $grades->push(
                    Grade::firstOrCreate(
                        ['student_id' => $student->id, 'subject_id' => $subjectId],
                        ['assignment' => 0, 'quiz' => 0, 'midterm' => 0, 'final' => 0, 'average' => 0]
                    )->load('student.user')
                );
            }
        }

        return view('teacher.grades.index', compact('subjects', 'subjectId', 'grades'));
    }

    public function update(GradeRequest $request, Grade $grade)
    {
        $teacher = Auth::user()->teacher;
        abort_unless($grade->subject->teacher_id === $teacher->id, 403);

        $grade->fill($request->validated());
        $grade->average = $grade->calculateAverage();
        $grade->grade = Grade::letterGrade($grade->average);
        $grade->approved = false; // needs re-approval by admin after edit
        $grade->save();

        return back()->with('success', 'Grade updated. Pending admin approval.');
    }
}
