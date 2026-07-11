@php
$links = [
    ['route' => 'teacher.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4M3 13v4l9 4 9-4v-4'],
    ['route' => 'teacher.classes.index', 'label' => 'My Classes', 'icon' => 'M12 6v6l4 2M12 3a9 9 0 100 18 9 9 0 000-18z'],
    ['route' => 'teacher.attendance.index', 'label' => 'Attendance', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ['route' => 'teacher.grades.index', 'label' => 'Grades', 'icon' => 'M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['route' => 'teacher.materials.index', 'label' => 'Course Materials', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0v6m-9-3v3l9 4 9-4v-3'],
    ['route' => 'teacher.announcements.index', 'label' => 'Announcements', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
    ['route' => 'teacher.profile.edit', 'label' => 'Profile', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
];
@endphp
@foreach ($links as $link)
    <a href="{{ route($link['route']) }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
       {{ request()->routeIs(explode('.index', $link['route'])[0].'*') || request()->routeIs($link['route']) ? 'bg-brand text-white' : 'text-slate-300 hover:bg-white/5' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/>
        </svg>
        {{ $link['label'] }}
    </a>
@endforeach
