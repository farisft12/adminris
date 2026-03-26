@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="relative min-h-screen bg-slate-50/50 pb-12 font-sans">
    {{-- Background Decoration --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-[30rem] w-[30rem] rounded-full bg-indigo-100/40 blur-3xl"></div>
        <div class="absolute right-0 bottom-0 h-[25rem] w-[25rem] rounded-full bg-violet-100/40 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-10 animate-fade-up">
            <nav class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-500 transition-colors">Admin</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span class="text-indigo-500">Manajemen Pengguna</span>
            </nav>
            <div class="flex items-center gap-4">
                <div class="bg-white text-indigo-600 p-3.5 rounded-2xl shadow-sm border border-slate-100">
                    <i class="fa-solid fa-users-gear text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kontrol Pengguna</h1>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Kelola akses, status aktivasi, dan peranan staff di dalam sistem.</p>
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid gap-6 sm:grid-cols-3 mb-10">
            @php
                $statCards = [
                    ['label' => 'Total Akun', 'value' => $totalUsers, 'icon' => 'fa-users', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                    ['label' => 'Administrator', 'value' => $adminCount, 'icon' => 'fa-shield-halved', 'bg' => 'bg-violet-50', 'text' => 'text-violet-600'],
                    ['label' => 'Staff Operasional', 'value' => $staffCount, 'icon' => 'fa-user-tie', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                ];
            @endphp
            @foreach($statCards as $i => $sc)
                <div class="group animate-fade-up rounded-3xl border border-white bg-white/70 p-6 shadow-sm backdrop-blur-xl hover:shadow-md transition-all duration-300" style="animation-delay: {{ ($i+1)*50 }}ms">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $sc['label'] }}</p>
                        <div class="h-10 w-10 flex items-center justify-center rounded-xl {{ $sc['bg'] }} {{ $sc['text'] }} transition-transform group-hover:scale-110 shadow-sm border border-white">
                            <i class="fa-solid {{ $sc['icon'] }} text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none">{{ $sc['value'] }}</h3>
                </div>
            @endforeach
        </div>

        {{-- Alerts --}}
        <div class="space-y-4 mb-8">
            @if (session('success'))
                <div class="animate-fade-up rounded-2xl border border-emerald-100 bg-emerald-50/80 backdrop-blur-md px-6 py-4 text-sm font-bold text-emerald-800 shadow-sm flex items-center gap-4">
                    <div class="bg-white h-8 w-8 rounded-lg flex items-center justify-center text-emerald-500 shadow-sm">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="animate-fade-up rounded-2xl border border-rose-100 bg-rose-50/80 backdrop-blur-md px-6 py-4 text-sm font-bold text-rose-800 shadow-sm flex items-center gap-4">
                    <div class="bg-white h-8 w-8 rounded-lg flex items-center justify-center text-rose-500 shadow-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Table Container --}}
        <div class="animate-fade-up rounded-[2.5rem] border border-white bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl overflow-hidden" style="animation-delay: 300ms">
            <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-black text-slate-800 tracking-tight">Daftar Akun Pengguna</h2>
                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">Informasi lengkap aksesibilitas pendaftar</p>
                </div>
                <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-slate-900 text-white shadow-lg shadow-slate-900/20">
                    <i class="fa-solid fa-fingerprint text-lg"></i>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50/50 text-left">
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Identitas</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Level Akses</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status Akun</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Bergabung</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Manajemen Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $u)
                            <tr class="group hover:bg-white transition-all duration-300">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-slate-100 font-black text-slate-500 text-sm shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 text-base leading-none">{{ $u->name }}</div>
                                            <div class="text-[11px] text-slate-400 font-bold font-mono mt-1 w-fit border-b border-dashed border-slate-200">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <span class="inline-flex items-center gap-1.5 rounded-xl border border-slate-100 bg-white px-3 py-1.5 text-[10px] font-black uppercase tracking-wider shadow-sm {{ $u->isAdmin() ? 'text-indigo-600' : 'text-slate-500' }}">
                                        @if($u->isAdmin())
                                            <i class="fa-solid fa-crown text-[8px] animate-bounce"></i>
                                        @else
                                            <i class="fa-solid fa-users-gear text-[8px]"></i>
                                        @endif
                                        {{ $u->role ?? 'user' }}
                                    </span>
                                </td>
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-2 rounded-full {{ $u->is_active ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.5)]' }}"></div>
                                        <span class="text-xs font-black {{ $u->is_active ? 'text-emerald-700' : 'text-rose-700' }}">
                                            {{ $u->is_active ? 'TER-AKTIVASI' : 'DIBLOKIR' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <div class="text-xs font-black text-slate-600">{{ $u->created_at?->translatedFormat('d F Y') }}</div>
                                    <div class="text-[9px] font-bold text-slate-400 italic mt-0.5">{{ $u->created_at?->diffForHumans() }}</div>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <form action="{{ route('admin.users.toggle-block', $u) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" 
                                            class="inline-flex items-center gap-2 rounded-2xl px-5 py-2.5 text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 border
                                            {{ $u->is_active 
                                                ? 'bg-rose-50 text-rose-600 border-rose-100 hover:bg-rose-600 hover:text-white hover:shadow-lg hover:shadow-rose-500/20' 
                                                : 'bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30' }}">
                                            <i class="fa-solid {{ $u->is_active ? 'fa-lock' : 'fa-lock-open' }} text-[9px]"></i>
                                            {{ $u->is_active ? 'Blokir Akses' : 'Buka Blokir' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-10 py-24 text-center">
                                    <div class="h-20 w-20 flex items-center justify-center rounded-3xl bg-slate-50 text-slate-200 mx-auto mb-6 shadow-inner">
                                        <i class="fa-solid fa-user-secret text-3xl"></i>
                                    </div>
                                    <h4 class="text-lg font-black text-slate-300 tracking-tighter uppercase italic">Belum Ada Database Pengguna</h4>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="px-10 py-8 bg-slate-50/30 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    .font-sans { font-family: 'Inter', sans-serif; }
    @keyframes fadeUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
    .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
</style>
@endsection
