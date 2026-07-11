@php
$links = [
    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4M3 13v4l9 4 9-4v-4'],
    ['route' => 'admin.students.index', 'label' => 'Students', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0v6m-9-3v3l9 4 9-4v-3'],
    ['route' => 'admin.teachers.index', 'label' => 'Teachers', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-2a4 4 0 100-8 4 4 0 000 8zm6 3a4 4 0 10-8 0'],
    ['route' => 'admin.classes.index', 'label' => 'Classes', 'icon' => 'M12 6v6l4 2M12 3a9 9 0 100 18 9 9 0 000-18z'],
    ['route' => 'admin.subjects.index', 'label' => 'Subjects', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
    ['route' => 'admin.attendance.index', 'label' => 'Attendance', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ['route' => 'admin.grades.index', 'label' => 'Grades', 'icon' => 'M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['route' => 'admin.announcements.index', 'label' => 'Announcements', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
    ['route' => 'admin.reports.index', 'label' => 'Reports', 'icon' => 'M9 17v-2a4 4 0 018 0v2M3 12a9 9 0 1018 0 9 9 0 00-18 0z'],
    ['route' => 'admin.settings.edit', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
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
