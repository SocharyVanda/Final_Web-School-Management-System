<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with(['teacher.user', 'schoolClass']);

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
        }

        $subjects = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        $classes = SchoolClass::orderBy('name')->get();
        return view('admin.subjects.create', compact('teachers', 'classes'));
    }

    public function store(SubjectRequest $request)
    {
        $subject = Subject::create($request->validated());

        foreach ($request->input('schedules', []) as $schedule) {
            if (!empty($schedule['day_of_week']) && !empty($schedule['start_time'])) {
                $subject->schedules()->create($schedule);
            }
        }

        return redirect()->route('admin.subjects.index')->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        $subject->load('schedules');
        $teachers = Teacher::with('user')->get();
        $classes = SchoolClass::orderBy('name')->get();
        return view('admin.subjects.edit', compact('subject', 'teachers', 'classes'));
    }

    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        $subject->schedules()->delete();
        foreach ($request->input('schedules', []) as $schedule) {
            if (!empty($schedule['day_of_week']) && !empty($schedule['start_time'])) {
                $subject->schedules()->create($schedule);
            }
        }

        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Subject deleted successfully.');
    }
}