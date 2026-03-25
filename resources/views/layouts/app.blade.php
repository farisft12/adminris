<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Adminris') }} - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col">
        @auth
        <nav class="sticky top-0 z-40 border-b border-slate-200/50 bg-white/80 shadow-sm backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    {{-- Logo & Primary Nav --}}
                    <div class="flex items-center gap-8">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="group flex items-center">
                            <span class="text-lg font-extrabold tracking-tight text-slate-900 group-hover:text-primary transition-colors">
                                {{ config('app.name', 'Adminris') }}
                            </span>
                        </a>
                        <div class="hidden sm:flex sm:items-center sm:gap-2">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition-all hover:bg-slate-100 hover:text-slate-900">
                                Dashboard
                            </a>
                        </div>
                    </div>

                    {{-- Profile Dropdown --}}
                    <div class="flex items-center gap-4">
                        <div x-data="{ open: false }" class="relative" @click.outside="open = false" @close.stop="open = false">
                            <button @click="open = !open" type="button" class="group flex items-center gap-3 rounded-full bg-slate-50 p-1 pr-3 shadow-inner shadow-slate-200/50 border border-slate-200 hover:bg-white hover:shadow-md transition-all focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-primary to-blue-600 text-white shadow-sm font-black text-sm tracking-widest">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden text-xs font-bold text-slate-700 sm:block max-w-[120px] truncate group-hover:text-primary transition-colors">
                                    {{ explode(' ', auth()->user()->name)[0] }}
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-primary transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-64 origin-top-right rounded-2xl border border-slate-100 bg-white/95 backdrop-blur-xl py-2 shadow-2xl focus:outline-none"
                                 style="display: none;">
                                
                                {{-- User Info --}}
                                <div class="border-b border-slate-100 px-4 py-3">
                                    <p class="truncate text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                                    <p class="mt-0.5 truncate text-[11px] font-medium text-slate-500">{{ auth()->user()->email ?? 'Akun Pengguna' }}</p>
                                    <div class="mt-2.5 inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-[9px] font-black uppercase tracking-widest text-primary">
                                        {{ auth()->user()->jabatan ?? auth()->user()->role }}
                                    </div>
                                    @if(auth()->user()->nip)
                                        <div class="mt-1 text-[10px] font-mono font-medium text-slate-400">NIP. {{ auth()->user()->nip }}</div>
                                    @endif
                                </div>

                                {{-- Links --}}
                                <div class="px-2 py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-blue-50 hover:text-primary transition-colors">
                                        <i class="fa-solid fa-user text-slate-400 w-4"></i> Pengaturan Profil
                                    </a>
                                </div>

                                {{-- Logout --}}
                                <div class="border-t border-slate-100 px-2 py-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2 text-left text-sm font-bold text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="fa-solid fa-arrow-right-from-bracket text-red-400 w-4"></i> Logout Sistem
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile Menu --}}
                <div class="border-t border-slate-100 py-3 sm:hidden">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center justify-center gap-2 rounded-xl bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                        <i class="fa-solid fa-gauge-high text-primary"></i> Buka Dashboard
                    </a>
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
