<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $student = Auth::user()->student()->with('user', 'schoolClass')->first();
        return view('student.profile.edit', compact('student'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $student->update(['phone' => $data['phone'] ?? null, 'address' => $data['address'] ?? null]);

        $userUpdate = [];
        if (!empty($data['password'])) {
            $userUpdate['password'] = Hash::make($data['password']);
        }
        if ($request->hasFile('photo')) {
            $userUpdate['photo'] = $request->file('photo')->store('photos', 'public');
        }
        if ($userUpdate) {
            $user->update($userUpdate);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
