@extends('layouts.app')
@section('title', 'Pengaturan Profil')

@php
    $errTab = 'profil';
    if ($errors->has('nip') || $errors->has('jabatan')) {
        $errTab = 'kepegawaian';
    }
    if ($errors->hasBag('updatePassword')) {
        $errTab = 'keamanan';
    }
@endphp

@section('content')
<div class="relative min-h-[calc(100vh-4rem)] bg-slate-50/50 pb-12">
    {{-- Subtle Background Decoration --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="absolute -left-20 top-20 h-96 w-96 rounded-full bg-blue-100/40 blur-3xl opacity-60"></div>
        <div class="absolute right-0 bottom-10 h-96 w-96 rounded-full bg-indigo-100/30 blur-3xl opacity-50"></div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8" x-data="{ activeTab: '{{ $errTab }}' }">
        
        {{-- Header Section --}}
        <div class="mb-10 animate-fade-up">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Pengaturan Akun</h1>
            <p class="mt-2 text-sm font-medium text-slate-500">Kelola informasi profil, data kepegawaian, dan preferensi keamanan Anda.</p>
        </div>

        {{-- Session Notifications --}}
        @if (session('success'))
            <div class="mb-6 animate-fade-up" style="animation-delay: 50ms">
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8 lg:gap-12">
            
            {{-- Sidebar Settings Menu --}}
            <div class="w-full md:w-64 shrink-0 animate-fade-up" style="animation-delay: 100ms">
                <nav class="flex flex-col gap-1.5">
                    <button @click="activeTab = 'profil'" :class="activeTab === 'profil' ? 'bg-white text-primary shadow-sm ring-1 ring-slate-900/5' : 'text-slate-600 hover:bg-slate-100/50 hover:text-slate-900'" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold transition-all text-left">
                        <div class="flex items-center gap-3">
                            <i class="fa-regular fa-user w-5 text-center text-lg" :class="activeTab === 'profil' ? 'text-primary' : 'text-slate-400'"></i>
                            Profil Umum
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                    </button>
                    
                    <button @click="activeTab = 'kepegawaian'" :class="activeTab === 'kepegawaian' ? 'bg-white text-primary shadow-sm ring-1 ring-slate-900/5' : 'text-slate-600 hover:bg-slate-100/50 hover:text-slate-900'" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold transition-all text-left">
                        <div class="flex items-center gap-3">
                            <i class="fa-regular fa-id-card w-5 text-center text-lg" :class="activeTab === 'kepegawaian' ? 'text-primary' : 'text-slate-400'"></i>
                            Data Kepegawaian
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                    </button>
                    
                    <button @click="activeTab = 'keamanan'" :class="activeTab === 'keamanan' ? 'bg-white text-primary shadow-sm ring-1 ring-slate-900/5' : 'text-slate-600 hover:bg-slate-100/50 hover:text-slate-900'" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold transition-all text-left">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-lock w-5 text-center text-lg" :class="activeTab === 'keamanan' ? 'text-primary' : 'text-slate-400'"></i>
                            Keamanan & Sandi
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                    </button>
                </nav>
            </div>

            {{-- Main Content --}}
            <div class="flex-1 max-w-3xl animate-fade-up" style="animation-delay: 150ms">
                
                {{-- Form: Profil Umum --}}
                <div x-show="activeTab === 'profil'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="rounded-2xl border border-white bg-white/70 shadow-xl shadow-slate-200/50 backdrop-blur-md p-6 sm:p-10">
                        
                        <div class="mb-8 flex items-center gap-6 border-b border-slate-100 pb-8">
                             <div class="h-20 w-20 shrink-0 rounded-full bg-slate-100 border border-slate-200 text-slate-400 text-3xl shadow-sm flex items-center justify-center">
                                  <i class="fa-solid fa-user"></i>
                             </div>
                             <div>
                                  <h2 class="text-xl font-extrabold text-slate-900">{{ auth()->user()->name }}</h2>
                                  <p class="text-sm font-medium text-slate-500 mt-1">{{ auth()->user()->email }}</p>
                                  <div class="mt-2 inline-flex items-center rounded-md bg-blue-50 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-widest text-primary border border-blue-100">
                                      Peran: {{ auth()->user()->role }}
                                  </div>
                             </div>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf @method('patch')
                            <input type="hidden" name="nip" value="{{ $user->nip }}">
                            <input type="hidden" name="jabatan" value="{{ $user->jabatan }}">
                            
                            <div class="grid gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Nama Lengkap</label>
                                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition-all focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none shadow-sm" />
                                    @error('name')<p class="mt-2 text-xs font-bold text-red-600 ml-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Alamat Email</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" readonly
                                        class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-500 outline-none shadow-sm cursor-not-allowed" />
                                </div>
                            </div>

                            <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-primary/30 transition-all hover:bg-blue-800 active:scale-95">
                                    <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Form: Data Kepegawaian --}}
                <div x-show="activeTab === 'kepegawaian'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" x-cloak>
                    <div class="rounded-2xl border border-white bg-white/70 shadow-xl shadow-slate-200/50 backdrop-blur-md p-6 sm:p-10">
                        
                        <div class="mb-8 border-b border-slate-100 pb-6">
                             <div>
                                 <h2 class="text-xl font-bold text-slate-900">Data Kepegawaian</h2>
                                 <p class="text-sm font-medium text-slate-500 mt-1">Lengkapi data identitas pekerjaan Anda saat ini.</p>
                             </div>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf @method('patch')
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            
                            <div class="space-y-6 max-w-xl">
                                <div>
                                    <label for="nip" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Nomor Induk Pegawai (NIP)</label>
                                    <input id="nip" name="nip" type="text" value="{{ old('nip', $user->nip) }}" placeholder="Belum diatur"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-900 transition-all focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 outline-none shadow-sm font-mono placeholder-slate-300" />
                                    @error('nip')<p class="mt-2 text-xs font-bold text-red-600 ml-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="jabatan" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Jabatan Fungsional</label>
                                    <input id="jabatan" name="jabatan" type="text" value="{{ old('jabatan', $user->jabatan) }}" placeholder="Contoh: Kepala Bagian Umum"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition-all focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 outline-none shadow-sm placeholder-slate-300" />
                                    @error('jabatan')<p class="mt-2 text-xs font-bold text-red-600 ml-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="pt-6 mt-8 border-t border-slate-100 flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:bg-black active:scale-95">
                                    <i class="fa-solid fa-briefcase text-xs opacity-70"></i> Perbarui Kepegawaian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Form: Keamanan & Sandi --}}
                <div x-show="activeTab === 'keamanan'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" x-cloak>
                    <div class="rounded-2xl border border-white bg-white/70 shadow-xl shadow-slate-200/50 backdrop-blur-md p-6 sm:p-10">
                        
                        <div class="mb-8 border-b border-slate-100 pb-6">
                             <div>
                                 <h2 class="text-xl font-bold text-slate-900">Ubah Kata Sandi</h2>
                                 <p class="text-sm font-medium text-slate-500 mt-1">Pastikan akun Anda menggunakan sandi acak yang panjang agar tetap aman.</p>
                             </div>
                        </div>

                        <form method="post" action="{{ route('profile.password.update') }}" class="space-y-6 max-w-xl">
                            @csrf @method('put')
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="current_password" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Password Saat Ini</label>
                                    <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-900 transition-all focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none shadow-sm tracking-[0.2em]" />
                                    @error('current_password', 'updatePassword')<p class="mt-2 text-xs font-bold text-red-600 ml-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Password Baru</label>
                                    <input id="password" name="password" type="password" required autocomplete="new-password"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-900 transition-all focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none shadow-sm tracking-[0.2em]" />
                                    @error('password', 'updatePassword')<p class="mt-2 text-xs font-bold text-red-600 ml-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Verifikasi Password Baru</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-900 transition-all focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none shadow-sm tracking-[0.2em]" />
                                    @error('password_confirmation', 'updatePassword')<p class="mt-2 text-xs font-bold text-red-600 ml-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            
                            <div class="pt-6 mt-8 border-t border-slate-100 flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:bg-black active:scale-95">
                                    <i class="fa-solid fa-lock text-xs opacity-70"></i> Terapkan Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.5s ease-out forwards;
        opacity: 0;
    }
</style>
@endsection