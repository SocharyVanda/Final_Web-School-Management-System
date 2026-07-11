<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $classIds = $teacher->classes()->pluck('id');

        $announcements = Announcement::where('created_by', Auth::id())
            ->orWhereIn('class_id', $classIds)
            ->orderByDesc('created_at')->paginate(10);

        return view('teacher.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        $classes = $teacher->classes;
        return view('teacher.announcements.create', compact('classes'));
    }

    public function store(AnnouncementRequest $request)
    {
        Announcement::create($request->validated() + ['created_by' => Auth::id()]);
        return redirect()->route('teacher.announcements.index')->with('success', 'Announcement posted.');
    }

    public function destroy(Announcement $announcement)
    {
        abort_unless($announcement->created_by === Auth::id(), 403);
        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }
}
