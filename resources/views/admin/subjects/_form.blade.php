<div class="space-y-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Subject Name</label>
            <input type="text" name="name" value="{{ old('name', $subject->name ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Subject Code</label>
            <input type="text" name="code" value="{{ old('code', $subject->code ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
            @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Teacher</label>
            <select name="teacher_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                <option value="">Unassigned</option>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}" @selected(old('teacher_id', $subject->teacher_id ?? '') == $t->id)>{{ $t->user->name }}</option>
                @endforeach
            </select>
            @error('teacher_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Class</label>
            <select name="class_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                <option value="">Unassigned</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" @selected(old('class_id', $subject->class_id ?? '') == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            @error('class_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- Schedules --}}
    <div class="border-t pt-5">
        <label class="block text-sm font-medium text-slate-700 mb-3">Schedule</label>
        <div id="schedules-container" class="space-y-3">
            @php
                $schedules = old('schedules', $subject->schedules ?? []);
                if ($schedules instanceof \Illuminate\Database\Eloquent\Collection) {
                    $schedules = $schedules->toArray();
                }
                if (empty($schedules)) {
                    $schedules = [['day_of_week' => '', 'start_time' => '', 'end_time' => '', 'room' => '', 'color' => '#2563EB']];
                }
            @endphp

            @foreach($schedules as $i => $schedule)
            <div class="schedule-row grid grid-cols-6 gap-2 items-end bg-slate-50 p-3 rounded-lg">
                <div>
                    <label class="text-xs text-slate-500">Day</label>
                    <select name="schedules[{{ $i }}][day_of_week]" class="w-full rounded border-slate-300 text-sm">
                        <option value="">--</option>
                        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d => $dayName)
                            <option value="{{ $d }}" {{ ($schedule['day_of_week'] ?? '') == $d ? 'selected' : '' }}>{{ $dayName }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Start</label>
                    <input type="time" name="schedules[{{ $i }}][start_time]" 
                           value="{{ isset($schedule['start_time']) ? \Carbon\Carbon::parse($schedule['start_time'])->format('H:i') : '' }}" 
                           min="06:00" max="21:00" 
                           class="w-full rounded border-slate-300 text-sm">
                </div>
                <div>
                    <label class="text-xs text-slate-500">End</label>
                    <input type="time" name="schedules[{{ $i }}][end_time]" 
                           value="{{ isset($schedule['end_time']) ? \Carbon\Carbon::parse($schedule['end_time'])->format('H:i') : '' }}" 
                           min="06:00" max="21:00" 
                           class="w-full rounded border-slate-300 text-sm">
                </div>
                <div>
                    <label class="text-xs text-slate-500">Room</label>
                    <input type="text" name="schedules[{{ $i }}][room]" value="{{ $schedule['room'] ?? '' }}" placeholder="Room" class="w-full rounded border-slate-300 text-sm">
                </div>
                <div>
                    <label class="text-xs text-slate-500">Color</label>
                    <input type="color" name="schedules[{{ $i }}][color]" value="{{ $schedule['color'] ?? '#2563EB' }}" class="w-full h-9 rounded border-slate-300 cursor-pointer">
                </div>
                <div>
                    <button type="button" onclick="this.closest('.schedule-row').remove()" class="text-red-500 hover:text-red-700 text-sm font-medium">Remove</button>
                </div>
            </div>
            @endforeach
        </div>
        <button type="button" onclick="addScheduleRow()" class="mt-3 text-sm text-blue-600 font-medium hover:underline">+ Add Schedule</button>
    </div>
</div>

<script>
function addScheduleRow() {
    const container = document.getElementById('schedules-container');
    const count = container.children.length;
    const row = document.createElement('div');
    row.className = 'schedule-row grid grid-cols-6 gap-2 items-end bg-slate-50 p-3 rounded-lg';
    row.innerHTML = `
        <div>
            <label class="text-xs text-slate-500">Day</label>
            <select name="schedules[${count}][day_of_week]" class="w-full rounded border-slate-300 text-sm">
                <option value="">--</option>
                <option value="0">Sun</option>
                <option value="1">Mon</option>
                <option value="2">Tue</option>
                <option value="3">Wed</option>
                <option value="4">Thu</option>
                <option value="5">Fri</option>
                <option value="6">Sat</option>
            </select>
        </div>
        <div>
            <label class="text-xs text-slate-500">Start</label>
            <input type="time" name="schedules[${count}][start_time]" min="06:00" max="21:00" class="w-full rounded border-slate-300 text-sm">
        </div>
        <div>
            <label class="text-xs text-slate-500">End</label>
            <input type="time" name="schedules[${count}][end_time]" min="06:00" max="21:00" class="w-full rounded border-slate-300 text-sm">
        </div>
        <div>
            <label class="text-xs text-slate-500">Room</label>
            <input type="text" name="schedules[${count}][room]" placeholder="Room" class="w-full rounded border-slate-300 text-sm">
        </div>
        <div>
            <label class="text-xs text-slate-500">Color</label>
            <input type="color" name="schedules[${count}][color]" value="#2563EB" class="w-full h-9 rounded border-slate-300 cursor-pointer">
        </div>
        <div>
            <button type="button" onclick="this.closest('.schedule-row').remove()" class="text-red-500 hover:text-red-700 text-sm font-medium">Remove</button>
        </div>
    `;
    container.appendChild(row);
}
</script>