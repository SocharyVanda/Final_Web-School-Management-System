<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Subject Name</label>
        <input type="text" name="name" value="{{ old('name', $subject->name ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Subject Code</label>
        <input type="text" name="code" value="{{ old('code', $subject->code ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Teacher</label>
        <select name="teacher_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">Unassigned</option>
            @foreach($teachers as $t)
                <option value="{{ $t->id }}" @selected(old('teacher_id', $subject->teacher_id ?? '') == $t->id)>{{ $t->user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Class</label>
        <select name="class_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            <option value="">Unassigned</option>
            @foreach($classes as $c)
                <option value="{{ $c->id }}" @selected(old('class_id', $subject->class_id ?? '') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
</div>
