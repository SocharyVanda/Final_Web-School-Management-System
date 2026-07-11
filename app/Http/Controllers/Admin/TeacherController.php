<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('user');

        if ($search = $request->get('search')) {
            $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
                ->orWhere('teacher_code', 'like', "%{$search}%");
        }

        if ($department = $request->get('department')) {
            $query->where('department', $department);
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $teachers = $query->paginate(10)->withQueryString();
        $departments = Teacher::whereNotNull('department')->distinct()->pluck('department');

        return view('admin.teachers.index', compact('teachers', 'departments'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(StoreTeacherRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request) {
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
            }

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'teacher',
                'status' => $data['status'],
                'photo' => $photoPath,
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'teacher_code' => 'TCH-' . str_pad((string) (Teacher::max('id') + 1), 5, '0', STR_PAD_LEFT),
                'department' => $data['department'] ?? null,
                'qualification' => $data['qualification'] ?? null,
                'salary' => $data['salary'] ?? null,
                'gender' => $data['gender'] ?? null,
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['user', 'classes', 'subjects']);
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request, $teacher) {
            $userUpdate = [
                'name' => $data['name'],
                'email' => $data['email'],
                'status' => $data['status'],
            ];

            if (!empty($data['password'])) {
                $userUpdate['password'] = Hash::make($data['password']);
            }

            if ($request->hasFile('photo')) {
                if ($teacher->user->photo) {
                    Storage::disk('public')->delete($teacher->user->photo);
                }
                $userUpdate['photo'] = $request->file('photo')->store('photos', 'public');
            }

            $teacher->user->update($userUpdate);

            $teacher->update([
                'department' => $data['department'] ?? null,
                'qualification' => $data['qualification'] ?? null,
                'salary' => $data['salary'] ?? null,
                'gender' => $data['gender'] ?? null,
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete();
        return back()->with('success', 'Teacher deleted successfully.');
    }

    public function resetPassword(Request $request, Teacher $teacher)
    {
        $request->validate(['password' => ['required', 'string', 'min:6']]);
        $teacher->user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', "Password reset for {$teacher->user->name}.");
    }

    public function assign(Request $request, Teacher $teacher)
    {
        // Assign teacher to classes/subjects from a multi-select form
        $request->validate([
            'class_ids' => ['nullable', 'array'],
            'subject_ids' => ['nullable', 'array'],
        ]);

        \App\Models\SchoolClass::whereIn('id', $request->class_ids ?? [])->update(['teacher_id' => $teacher->id]);
        \App\Models\Subject::whereIn('id', $request->subject_ids ?? [])->update(['teacher_id' => $teacher->id]);

        return back()->with('success', 'Assignments updated.');
    }
}
