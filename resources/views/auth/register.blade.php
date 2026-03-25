@extends('layouts.guest')

@section('title', 'Daftar Akun Baru')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
    @keyframes slideUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
    .animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endpush

@section('content')
    <div class="fixed top-0 right-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-60 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-60 -translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

    <div class="w-full max-w-[440px] z-10 animate-slide-up my-auto py-8">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-2 transition-transform hover:scale-105">
                <div class="bg-primary text-white p-2 rounded-lg shadow-lg">
                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                </div>
                <span class="font-bold text-2xl tracking-tight text-primary">Admin<span class="text-secondary">ris</span></span>
            </a>
        </div>

        <div class="glass-card rounded-[2.5rem] shadow-2xl shadow-blue-900/5 p-8 sm:p-10 relative">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Buat Akun Pribadi</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Ketik nama Anda" class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300 @error('name') border-red-400 @enderror">
                    @error('name')<p class="mt-1 text-sm text-red-500 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com" class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300 @error('email') border-red-400 @enderror">
                    @error('email')<p class="mt-1 text-sm text-red-500 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Kata Sandi</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" 
                        class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300 @error('password') border-red-400 @enderror">
                    
                    <div class="mt-2 flex gap-1 px-1 h-1">
                        <div id="bar-1" class="h-full w-full rounded-full bg-gray-200 transition-all duration-500"></div>
                        <div id="bar-2" class="h-full w-full rounded-full bg-gray-200 transition-all duration-500"></div>
                        <div id="bar-3" class="h-full w-full rounded-full bg-gray-200 transition-all duration-500"></div>
                    </div>
                    <p id="strength-text" class="text-[10px] font-bold uppercase mt-1 text-gray-400 ml-1">Sandi belum diisi</p>
                    @error('password')<p class="mt-1 text-sm text-red-500 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-1 pt-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi sandi baru" 
                        class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:scale-[1.02] active:scale-95">
                        Daftar Akun Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-6 flex items-center justify-between">
                <span class="w-1/5 border-b border-gray-200"></span>
                <span class="text-xs text-center text-gray-500 uppercase font-bold tracking-wider">Atau daftar dengan</span>
                <span class="w-1/5 border-b border-gray-200"></span>
            </div>

            <div class="mt-6">
                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3.5 rounded-2xl shadow-sm transition-all transform hover:scale-[1.02] active:scale-95">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                    Lanjutkan dengan Google
                </a>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 text-center">
                <p class="text-sm text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Masuk</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        const bars = [document.getElementById('bar-1'), document.getElementById('bar-2'), document.getElementById('bar-3')];
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', function() {
            const val = passwordInput.value;
            let strength = 0;

            if (val.length >= 6) strength = 1; 
            if (val.length >= 8 && /[A-Z]/.test(val) && /[0-9]/.test(val)) strength = 2; 
            if (val.length >= 10 && /[^A-Za-z0-9]/.test(val)) strength = 3; 

            bars.forEach(bar => bar.className = 'h-full w-full rounded-full bg-gray-200 transition-all duration-500');

            if (strength === 0 && val.length > 0) {
                strengthText.innerText = "Terlalu Pendek";
                strengthText.className = "text-[10px] font-bold uppercase mt-1 text-red-400 ml-1";
            } else if (strength === 1) {
                bars[0].classList.replace('bg-gray-200', 'bg-red-400');
                strengthText.innerText = "Lemah";
                strengthText.className = "text-[10px] font-bold uppercase mt-1 text-red-400 ml-1";
            } else if (strength === 2) {
                bars[0].classList.replace('bg-gray-200', 'bg-amber-400');
                bars[1].classList.replace('bg-gray-200', 'bg-amber-400');
                strengthText.innerText = "Sedang";
                strengthText.className = "text-[10px] font-bold uppercase mt-1 text-amber-500 ml-1";
            } else if (strength === 3) {
                bars[0].classList.replace('bg-gray-200', 'bg-emerald-400');
                bars[1].classList.replace('bg-gray-200', 'bg-emerald-400');
                bars[2].classList.replace('bg-gray-200', 'bg-emerald-400');
                strengthText.innerText = "Sangat Kuat";
                strengthText.className = "text-[10px] font-bold uppercase mt-1 text-emerald-500 ml-1";
            } else if (val.length === 0) {
                strengthText.innerText = "Sandi belum diisi";
                strengthText.className = "text-[10px] font-bold uppercase mt-1 text-gray-400 ml-1";
            }
        });
    }
</script>
@endpush
