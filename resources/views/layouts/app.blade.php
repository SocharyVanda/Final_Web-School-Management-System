<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $setting = \App\Models\Setting::first();
        $schoolName = $setting?->school_name ?? 'EduFlow';
        $logoUrl = $setting?->logo ? asset('storage/' . $setting->logo) : null;
    @endphp
    <title>@yield('title', 'Dashboard') - {{ $schoolName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#2563EB',
                            dark: '#1D4ED8',
                        },
                        sidebar: '#1E293B',
                        bg: '#F8FAFC',
                    },
                    borderRadius: { card: '14px' },
                    boxShadow: { soft: '0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04)' },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    @stack('styles')
</head>
<body class="bg-bg text-slate-800 antialiased">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-sidebar text-slate-200 flex flex-col fixed inset-y-0 left-0">
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="Logo" class="h-9 w-9 rounded-lg object-cover">
            @else
                <div class="w-9 h-9 rounded-lg bg-brand flex items-center justify-center font-bold text-white">EF</div>
            @endif
            <div>
                <p class="font-bold text-white leading-tight">{{ $schoolName }}</p>
                <p class="text-xs text-slate-400 leading-tight">{{ ucfirst(auth()->user()->role) }} Portal</p>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @php $role = auth()->user()->role; @endphp

            @if($role === 'admin')
                @include('layouts.nav.admin')
            @elseif($role === 'teacher')
                @include('layouts.nav.teacher')
            @else
                @include('layouts.nav.student')
            @endif
        </nav>

        <div class="px-3 py-4 border-t border-white/10 space-y-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-300 hover:bg-white/5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-10">
            <div class="relative w-96 max-w-full">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Search students, faculty, or resources..." class="w-full pl-9 pr-3 py-2 rounded-lg bg-slate-100 text-sm border-none focus:ring-2 focus:ring-brand focus:bg-white transition">
            </div>
            <div class="flex items-center gap-4">
                <button class="relative text-slate-500 hover:text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
                <div class="w-px h-8 bg-slate-200"></div>
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-brand text-white flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 uppercase">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-6 flex-1">
            @if (session('success'))
                <div class="mb-4 rounded-card bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-card bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>