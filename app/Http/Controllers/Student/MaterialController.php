<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        $subjectIds = $student->subjects()->pluck('subjects.id');

        $materials = CourseMaterial::whereIn('subject_id', $subjectIds)->with('subject')->latest()->get();

        return view('student.materials.index', compact('materials'));
    }

    public function download(CourseMaterial $material)
    {
        $student = Auth::user()->student;
        $subjectIds = $student->subjects()->pluck('subjects.id');
        abort_unless($subjectIds->contains($material->subject_id), 403);

        return Storage::disk('public')->download($material->file_path, $material->title);
    }
}
