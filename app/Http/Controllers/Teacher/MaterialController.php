<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $materials = CourseMaterial::where('teacher_id', $teacher->id)->with('subject')->latest()->get();
        $subjects = $teacher->subjects;

        return view('teacher.materials.index', compact('materials', 'subjects'));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        $data = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png', 'max:10240'],
        ]);

        $subject = Subject::findOrFail($data['subject_id']);
        abort_unless($subject->teacher_id === $teacher->id, 403);

        $path = $request->file('file')->store('materials', 'public');

        CourseMaterial::create([
            'subject_id' => $data['subject_id'],
            'teacher_id' => $teacher->id,
            'title' => $data['title'],
            'file_path' => $path,
            'file_type' => $request->file('file')->getClientOriginalExtension(),
        ]);

        return back()->with('success', 'Material uploaded successfully.');
    }

    public function destroy(CourseMaterial $material)
    {
        abort_unless($material->teacher_id === Auth::user()->teacher->id, 403);
        \Illuminate\Support\Facades\Storage::disk('public')->delete($material->file_path);
        $material->delete();
        return back()->with('success', 'Material removed.');
    }
}
