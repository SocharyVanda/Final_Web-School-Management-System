<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first() ?? Setting::create([
            'school_name' => 'EduFlow',
            'academic_year' => '',
            'semester' => '',
        ]);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:50'],
            'semester' => ['required', 'string', 'max:50'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $setting = Setting::first() ?? new Setting();

        if ($request->hasFile('logo')) {
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $setting->fill($data)->save();

        return back()->with('success', 'Settings updated.');
    }
}