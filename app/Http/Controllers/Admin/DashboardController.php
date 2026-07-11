<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = SchoolClass::count();
        $activeClassesPercent = $totalClasses > 0 ? 92 : 0;

        $todayAttendanceRate = 0;
        $todayTotal = Attendance::whereDate('date', today())->count();
        if ($todayTotal > 0) {
            $todayPresent = Attendance::whereDate('date', today())
                ->whereIn('status', ['present', 'late'])->count();
            $todayAttendanceRate = round(($todayPresent / $todayTotal) * 100, 1);
        }

        // Enrollment trend for the last 6 months
        $months = collect(range(5, 0))->map(function ($i) {
            $month = Carbon::now()->subMonths($i);
            return [
                'label' => $month->format('M'),
                'count' => Student::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)->count(),
            ];
        });

        $recentActivity = collect()
            ->concat(Student::latest()->take(3)->get()->map(fn ($s) => [
                'text' => "New student added: {$s->user->name}",
                'time' => $s->created_at,
            ]))
            ->concat(Teacher::latest()->take(2)->get()->map(fn ($t) => [
                'text' => "Teacher added: {$t->user->name}",
                'time' => $t->created_at,
            ]))
            ->sortByDesc('time')
            ->take(6);

        $pendingLeaveRequests = 0; // placeholder for future leave-request feature

        return view('admin.dashboard', compact(
            'totalStudents', 'totalTeachers', 'totalClasses',
            'activeClassesPercent', 'todayAttendanceRate', 'months',
            'recentActivity', 'pendingLeaveRequests'
        ));
    }
}
