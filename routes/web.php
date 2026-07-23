<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', Admin\StudentController::class);
    Route::post('students/{student}/reset-password', [Admin\StudentController::class, 'resetPassword'])->name('students.reset-password');
    Route::resource('teachers', Admin\TeacherController::class);
    Route::post('teachers/{teacher}/reset-password', [Admin\TeacherController::class, 'resetPassword'])->name('teachers.reset-password');
    Route::post('teachers/{teacher}/assign', [Admin\TeacherController::class, 'assign'])->name('teachers.assign');
    Route::resource('classes', Admin\SchoolClassController::class)->parameters(['classes' => 'class']);
    Route::resource('subjects', Admin\SubjectController::class);
    Route::get('attendance', [Admin\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/export/pdf', [Admin\AttendanceController::class, 'exportPdf'])->name('attendance.export-pdf');
    Route::get('attendance/export/excel', [Admin\AttendanceController::class, 'exportExcel'])->name('attendance.export-excel');
    Route::get('grades', [Admin\GradeController::class, 'index'])->name('grades.index');
    Route::patch('grades/{grade}', [Admin\GradeController::class, 'update'])->name('grades.update');
    Route::post('grades/{grade}/approve', [Admin\GradeController::class, 'approve'])->name('grades.approve');
    Route::resource('announcements', Admin\AnnouncementController::class);
    Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/students', [Admin\ReportController::class, 'studentList'])->name('reports.students');
    Route::get('reports/teachers', [Admin\ReportController::class, 'teacherList'])->name('reports.teachers');
    Route::get('reports/grades', [Admin\ReportController::class, 'gradeReport'])->name('reports.grades');
    Route::get('reports/class/{class}', [Admin\ReportController::class, 'classReport'])->name('reports.class');
    Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [Teacher\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/classes', [Teacher\DashboardController::class, 'classes'])->name('classes.index');
    Route::get('attendance', [Teacher\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance', [Teacher\AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('grades', [Teacher\GradeController::class, 'index'])->name('grades.index');
    Route::patch('grades/{grade}', [Teacher\GradeController::class, 'update'])->name('grades.update');
    Route::get('materials', [Teacher\MaterialController::class, 'index'])->name('materials.index');
    Route::post('materials', [Teacher\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('materials/{material}', [Teacher\MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::resource('announcements', Teacher\AnnouncementController::class)->only(['index', 'show', 'create', 'store', 'destroy']);
    Route::get('profile', [Teacher\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [Teacher\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('attendance', [Student\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('grades', [Student\GradeController::class, 'index'])->name('grades.index');
    Route::get('materials', [Student\MaterialController::class, 'index'])->name('materials.index');
    Route::get('materials/{material}/download', [Student\MaterialController::class, 'download'])->name('materials.download');
    Route::get('announcements', [Student\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('announcements/{announcement}', [Student\AnnouncementController::class, 'show'])->name('announcements.show');
    Route::get('profile', [Student\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [Student\ProfileController::class, 'update'])->name('profile.update');
});