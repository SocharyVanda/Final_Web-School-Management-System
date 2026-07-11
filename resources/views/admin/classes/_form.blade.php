<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Class Name</label>
        <input type="text" name="name" value="{{ old('name', $class->name ?? '') }}" required placeholder="e.g. Grade 10A" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Room</label>
        <input type="text" name="room" value="{{ old('room', $class->room ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Homeroom Teacher</label>
        <select name="teacher_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">Unassigned</option>
            @foreach($teachers as $t)
                <option value="{{ $t->id }}" @selected(old('teacher_id', $class->teacher_id ?? '') == $t->id)>{{ $t->user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Capacity</label>
        <input type="number" name="capacity" value="{{ old('capacity', $class->capacity ?? 30) }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
</div>
