<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function studentList()
    {
        // Requires barryvdh/laravel-dompdf
        $students = Student::with(['user', 'schoolClass'])->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.students-pdf', compact('students'));
        return $pdf->download('student-list.pdf');
    }

    public function teacherList()
    {
        $teachers = Teacher::with('user')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.teachers-pdf', compact('teachers'));
        return $pdf->download('teacher-list.pdf');
    }

    public function gradeReport()
    {
        $grades = Grade::with(['student.user', 'subject'])->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.grades-pdf', compact('grades'));
        return $pdf->download('grade-report.pdf');
    }

    public function classReport(SchoolClass $class)
    {
        $class->load('students.user', 'subjects');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.class-pdf', compact('class'));
        return $pdf->download("class-report-{$class->name}.pdf");
    }
}
