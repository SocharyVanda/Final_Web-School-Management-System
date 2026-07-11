<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
        <input type="text" name="name" value="{{ old('name', $student->user->name ?? '') }}" required
            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $student->user->email ?? '') }}" required
            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">{{ $student ? 'New Password (optional)' : 'Password' }}</label>
        <input type="password" name="password" {{ $student ? '' : 'required' }}
            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Gender</label>
        <select name="gender" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">Select</option>
            @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $val => $label)
                <option value="{{ $val }}" @selected(old('gender', $student->gender ?? '') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Date of Birth</label>
        <input type="date" name="dob" value="{{ old('dob', $student->dob ?? '') }}"
            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $student->phone ?? '') }}"
            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
        <input type="text" name="address" value="{{ old('address', $student->address ?? '') }}"
            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Guardian Name</label>
        <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name ?? '') }}"
            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Guardian Phone</label>
        <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone ?? '') }}"
            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Class</label>
        <select name="class_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">Unassigned</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" @selected(old('class_id', $student->class_id ?? '') == $class->id)>{{ $class->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
        <select name="status" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="active" @selected(old('status', $student->user->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $student->user->status ?? '') === 'inactive')>Inactive</option>
        </select>
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Photo</label>
        <input type="file" name="photo" accept="image/*" class="w-full text-sm">
    </div>
</div>
