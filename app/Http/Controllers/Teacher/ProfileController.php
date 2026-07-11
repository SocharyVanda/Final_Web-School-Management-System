<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $teacher = Auth::user()->teacher()->with('user')->first();
        return view('teacher.profile.edit', compact('teacher'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $teacher->update(['phone' => $data['phone'] ?? null, 'address' => $data['address'] ?? null]);

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
