<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(['student.user', 'subject']);

        if ($classId = $request->get('class_id')) {
            $query->whereHas('student', fn ($q) => $q->where('class_id', $classId));
        }

        if ($subjectId = $request->get('subject_id')) {
            $query->where('subject_id', $subjectId);
        }

        $grades = $query->orderByDesc('updated_at')->paginate(20)->withQueryString();
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('admin.grades.index', compact('grades', 'classes', 'subjects'));
    }

    public function approve(Grade $grade)
    {
        $grade->update(['approved' => true]);
        return back()->with('success', 'Grade approved.');
    }

    public function update(Request $request, Grade $grade)
    {
        $data = $request->validate([
            'assignment' => ['required', 'numeric', 'min:0', 'max:100'],
            'quiz' => ['required', 'numeric', 'min:0', 'max:100'],
            'midterm' => ['required', 'numeric', 'min:0', 'max:100'],
            'final' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $grade->fill($data);
        $grade->average = $grade->calculateAverage();
        $grade->grade = Grade::letterGrade($grade->average);
        $grade->save();

        return back()->with('success', 'Grade updated.');
    }
}
