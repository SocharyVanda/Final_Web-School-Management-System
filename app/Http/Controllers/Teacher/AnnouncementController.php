<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

class AnnouncementController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $classIds = $teacher->classes()->pluck('id');

        $announcements = Announcement::where(function ($q) use ($classIds) {
            $q->whereIn('target_role', ['all', 'teacher'])
            ->where(function ($q2) use ($classIds) {
                $q2->whereNull('class_id')->orWhereIn('class_id', $classIds);
            });
        })
        ->orWhere('created_by', Auth::id())
        ->orderByDesc('created_at')->paginate(10);

        return view('teacher.announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        $teacher = Auth::user()->teacher;
        $classIds = $teacher->classes()->pluck('id');

        abort_unless(
            $announcement->created_by === Auth::id() || $classIds->contains($announcement->class_id),
            403
        );

        return view('teacher.announcements.show', compact('announcement'));
    }

    public function create()
    {
        $teacher = Auth::user()->teacher;
        $classes = $teacher->classes;
        return view('teacher.announcements.create', compact('classes'));
    }

    public function store(AnnouncementRequest $request)
    {
        $data = $request->validated();
        $data['description'] = Purifier::clean($data['description']);

        Announcement::create($data + ['created_by' => Auth::id()]);
        return redirect()->route('teacher.announcements.index')->with('success', 'Announcement posted.');
    }

    public function destroy(Announcement $announcement)
    {
        abort_unless($announcement->created_by === Auth::id(), 403);
        $announcement->delete();
        return redirect()->route('teacher.announcements.index')->with('success', 'Announcement deleted.');
    }
}