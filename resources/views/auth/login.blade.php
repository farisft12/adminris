@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="guest-page min-h-screen">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.06\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <a href="{{ url('/') }}" class="mb-8 inline-flex items-center gap-2 text-sm text-slate-400 transition-colors hover:text-white">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <div class="animate-scale-in rounded-2xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-xl opacity-0-init" style="animation-fill-mode: forwards;">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold tracking-tight text-white">Masuk ke akun</h2>
                    <p class="mt-1 text-slate-400">Gunakan email dan password Anda.</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div class="animate-fade-in-up opacity-0-init" style="animation-delay: 0.1s; animation-fill-mode: forwards;">
                        <label for="email" class="mb-1.5 block text-sm font-medium text-slate-300">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="input-guest w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-slate-500 shadow-inner transition-all duration-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/30 @error('email') border-red-400/50 focus:border-red-400 focus:ring-red-400/30 @enderror"
                            placeholder="nama@email.com" />
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="animate-fade-in-up opacity-0-init" style="animation-delay: 0.15s; animation-fill-mode: forwards;">
                        <label for="password" class="mb-1.5 block text-sm font-medium text-slate-300">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="input-guest w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-slate-500 shadow-inner transition-all duration-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/30 @error('password') border-red-400/50 focus:border-red-400 focus:ring-red-400/30 @enderror"
                            placeholder="••••••••" />
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="animate-fade-in-up opacity-0-init flex items-center" style="animation-delay: 0.2s; animation-fill-mode: forwards;">
                        <input id="remember" type="checkbox" name="remember"
                            class="h-4 w-4 rounded border-white/20 bg-white/5 text-indigo-500 focus:ring-indigo-400/50" />
                        <label for="remember" class="ml-2.5 text-sm text-slate-400">Ingat saya</label>
                    </div>
                    <div class="animate-fade-in-up opacity-0-init pt-1" style="animation-delay: 0.25s; animation-fill-mode: forwards;">
                        <button type="submit" class="btn-guest-primary group flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3.5 text-sm font-semibold text-white shadow-lg transition-all duration-300">
                            Masuk
                            <span class="inline-block transition-transform duration-300 group-hover:translate-x-0.5">→</span>
                        </button>
                    </div>
                </form>
                <p class="mt-6 animate-fade-in-up text-center text-sm text-slate-400 opacity-0-init" style="animation-delay: 0.3s; animation-fill-mode: forwards;">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-400 transition-colors hover:text-indigo-300">Daftar</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
