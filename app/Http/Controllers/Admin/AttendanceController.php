<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student.user', 'subject', 'teacher.user']);

        if ($classId = $request->get('class_id')) {
            $query->whereHas('student', fn ($q) => $q->where('class_id', $classId));
        }

        if ($subjectId = $request->get('subject_id')) {
            $query->where('subject_id', $subjectId);
        }

        if ($date = $request->get('date')) {
            $query->whereDate('date', $date);
        }

        $attendances = $query->orderByDesc('date')->paginate(20)->withQueryString();
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('admin.attendance.index', compact('attendances', 'classes', 'subjects'));
    }

    public function exportPdf(Request $request)
    {
        // Requires: composer require barryvdh/laravel-dompdf
        $attendances = Attendance::with(['student.user', 'subject'])
            ->when($request->class_id, fn ($q) => $q->whereHas('student', fn ($s) => $s->where('class_id', $request->class_id)))
            ->when($request->date, fn ($q) => $q->whereDate('date', $request->date))
            ->orderByDesc('date')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.attendance-pdf', compact('attendances'));
        return $pdf->download('attendance-report.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Requires: composer require maatwebsite/excel
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AttendanceExport($request->all()),
            'attendance-report.xlsx'
        );
    }
}
