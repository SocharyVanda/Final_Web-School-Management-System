<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolClassRequest;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $query = SchoolClass::with('teacher.user')->withCount('students');

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $classes = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.classes.create', compact('teachers'));
    }

    public function store(SchoolClassRequest $request)
    {
        SchoolClass::create($request->validated());
        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    public function edit(SchoolClass $class)
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    public function update(SchoolClassRequest $request, SchoolClass $class)
    {
        $class->update($request->validated());
        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return back()->with('success', 'Class deleted successfully.');
    }
}
