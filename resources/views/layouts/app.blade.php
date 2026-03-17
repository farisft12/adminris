<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Adminris') }} - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col">
        @auth
        <nav class="sticky top-0 z-10 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur supports-[backdrop-filter]:bg-white/80">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-14 items-center justify-between gap-4 sm:h-16">
                    <div class="flex min-w-0 flex-1 items-center gap-6 sm:gap-8">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="shrink-0 text-lg font-bold tracking-tight text-slate-900 transition opacity-90 hover:opacity-100">
                            {{ config('app.name') }}
                        </a>
                        <div class="hidden gap-0.5 sm:flex">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="nav-link rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Dashboard</a>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-3">
                        <span class="hidden max-w-[140px] truncate text-sm text-slate-500 sm:block" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</span>
                        <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">{{ auth()->user()->role }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Logout</button>
                        </form>
                    </div>
                </div>
                <div class="flex gap-0.5 border-t border-slate-100 py-2 sm:hidden">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="nav-link rounded-lg px-3 py-2 text-sm font-medium text-slate-600">Dashboard</a>
                </div>
            </div>
        </nav>
        @endauth

        <main class="flex-1 py-6 sm:py-8">
            @if (session('success'))
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-4 animate-fade-in-up">
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50/90 px-4 py-3 text-sm text-emerald-800 shadow-sm">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-4 animate-fade-in-up">
                    <div class="rounded-xl border border-red-200 bg-red-50/90 px-4 py-3 text-sm text-red-800 shadow-sm">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
