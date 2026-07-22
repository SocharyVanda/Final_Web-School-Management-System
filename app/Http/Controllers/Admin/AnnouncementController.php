<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with(['author', 'schoolClass']);

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $announcements = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();
        return view('admin.announcements.create', compact('classes'));
    }

    public function store(AnnouncementRequest $request)
    {
        $data = $request->validated();
        $data['description'] = Purifier::clean($data['description']);

        Announcement::create($data + ['created_by' => $request->user()->id]);
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement posted.');
    }

    public function edit(Announcement $announcement)
    {
        $classes = SchoolClass::orderBy('name')->get();
        return view('admin.announcements.edit', compact('announcement', 'classes'));
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $data = $request->validated();
        $data['description'] = Purifier::clean($data['description']);

        $announcement->update($data);
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }
}