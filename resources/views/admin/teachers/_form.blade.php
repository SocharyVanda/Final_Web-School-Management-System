<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
        <input type="text" name="name" value="{{ old('name', $teacher->user->name ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $teacher->user->email ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">{{ $teacher ? 'New Password (optional)' : 'Password' }}</label>
        <input type="password" name="password" {{ $teacher ? '' : 'required' }} class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Gender</label>
        <select name="gender" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">Select</option>
            @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $val => $label)
                <option value="{{ $val }}" @selected(old('gender', $teacher->gender ?? '') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $teacher->phone ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Department</label>
        <input type="text" name="department" value="{{ old('department', $teacher->department ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Qualification</label>
        <input type="text" name="qualification" value="{{ old('qualification', $teacher->qualification ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Salary (optional)</label>
        <input type="number" step="0.01" name="salary" value="{{ old('salary', $teacher->salary ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
        <input type="text" name="address" value="{{ old('address', $teacher->address ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
        <select name="status" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="active" @selected(old('status', $teacher->user->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $teacher->user->status ?? '') === 'inactive')>Inactive</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Photo</label>
        <input type="file" name="photo" accept="image/*" class="w-full text-sm">
    </div>
</div>
