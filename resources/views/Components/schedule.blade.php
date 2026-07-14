@props(['schedules'])

@php
    $days = [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri'];
    $startHour = 8;
    $endHour = 18;
    $totalHeight = ($endHour - $startHour) * 60;
@endphp

<div class="bg-white rounded-card shadow-soft p-6">
    <h2 class="font-semibold text-slate-800 mb-4">My Weekly Schedule</h2>

    @if(empty($schedules) || count($schedules) === 0)
        <div class="text-center py-12 text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm">No scheduled classes yet.</p>
            <p class="text-xs mt-1 opacity-70">Add subjects with schedule times to see them here.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <div class="min-w-[700px]">
                <!-- Day headers -->
                <div class="grid grid-cols-[60px_repeat(5,1fr)] mb-1">
                    <div></div>
                    @foreach($days as $label)
                        <div class="text-xs font-semibold text-slate-500 text-center py-2">{{ $label }}</div>
                    @endforeach
                </div>

                <!-- Grid body -->
                <div class="relative grid grid-cols-[60px_repeat(5,1fr)]" style="height: {{ $totalHeight }}px;">
                    <!-- Hour labels -->
                    <div class="relative">
                        @for($h = $startHour; $h < $endHour; $h++)
                            <div class="absolute text-xs text-slate-400" style="top: {{ ($h - $startHour) * 60 }}px;">
                                {{ \Carbon\Carbon::createFromTime($h, 0)->format('g A') }}
                            </div>
                        @endfor
                    </div>

                    <!-- Day columns -->
                    @foreach($days as $dayNum => $label)
                        <div class="relative border-l border-slate-100">
                            @for($h = $startHour; $h < $endHour; $h++)
                                <div class="absolute w-full border-t border-slate-50" style="top: {{ ($h - $startHour) * 60 }}px;"></div>
                            @endfor

                            @foreach(collect($schedules)->where('day_of_week', $dayNum) as $slot)
                                @php
                                    $start = \Carbon\Carbon::parse($slot['start_time']);
                                    $end = \Carbon\Carbon::parse($slot['end_time']);

                                    if ($end->lt($start)) {
                                        continue;
                                    }

                                    $top = (($start->hour - $startHour) * 60) + $start->minute;
                                    $height = $start->diffInMinutes($end);

                                    $subjectCode = $slot['subject_code'] ?? ($slot['subject']['code'] ?? '—');
                                    $teacherName = $slot['teacher_name'] ?? ($slot['subject']['teacher']['name'] ?? null);
                                    $room = $slot['room'] ?? null;
                                    $color = $slot['color'] ?? '#2563eb';
                                @endphp
                                @if($height > 0 && $height <= 240)
                                    <div class="absolute inset-x-1 rounded-lg px-2 py-1 text-white overflow-hidden shadow-sm cursor-pointer hover:opacity-90 transition-opacity"
                                         style="top: {{ $top }}px; height: {{ max($height, 30) }}px; background-color: {{ $color }}; width: calc(100% - 8px);">
                                        <p class="text-xs font-semibold leading-tight truncate">{{ $subjectCode }}</p>
                                        <p class="text-[10px] leading-tight opacity-90">{{ $start->format('g:i') }}-{{ $end->format('g:i A') }}</p>
                                        @if($teacherName)
                                            <p class="text-[10px] leading-tight opacity-80 truncate">{{ $teacherName }}</p>
                                        @endif
                                        @if($room)
                                            <p class="text-[10px] leading-tight opacity-80 truncate">{{ $room }}</p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>