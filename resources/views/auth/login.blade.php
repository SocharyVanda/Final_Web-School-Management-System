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
    <title>Login - {{ $schoolName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="flex items-center gap-3 justify-center mb-8">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="Logo" class="h-10 w-auto rounded">
            @else
                <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold">EF</div>
            @endif
            <span class="text-xl font-bold text-slate-800">{{ $schoolName }}</span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <h1 class="text-xl font-bold text-slate-800 mb-1">Welcome back</h1>
            <p class="text-sm text-slate-500 mb-6">Sign in with the credentials provided by your administrator.</p>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                    Remember me
                </label>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-2.5 rounded-lg transition">
                    Sign in
                </button>
            </form>
        </div>
        <p class="text-center text-xs text-slate-400 mt-6">Accounts are created by school administrators only.</p>
    </div>
</body>
</html>