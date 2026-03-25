<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Adminris</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Animations */
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .animate-fade-up {
            animation: fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Staggered delays for feature cards */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }

        /* Glassmorphism background */
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
    </style>
</head>
<body class="font-sans text-gray-800 bg-slate-50 overflow-x-hidden">

    <nav class="glass-nav fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2 cursor-pointer animate-fade-up">
                    <div class="bg-primary text-white p-2 rounded-lg">
                        <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-primary">Admin<span class="text-secondary">ris</span></span>
                </div>
                <div class="hidden md:flex space-x-8 items-center animate-fade-up delay-100">
                    <a href="#fitur" class="text-gray-600 hover:text-primary transition-colors font-medium">Fitur</a>
                    <a href="#tentang" class="text-gray-600 hover:text-primary transition-colors font-medium">Tentang</a>
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="bg-primary hover:bg-blue-900 text-white px-6 py-2.5 rounded-full font-medium transition-all transform hover:scale-105 hover:shadow-lg flex items-center">
                            Dashboard <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-primary hover:bg-blue-900 text-white px-6 py-2.5 rounded-full font-medium transition-all transform hover:scale-105 hover:shadow-lg flex items-center">
                            Masuk Sistem <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100 blur-3xl opacity-50 animate-float"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-200 blur-3xl opacity-50 animate-float" style="animation-delay: -3s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="max-w-2xl">
                    <div class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-primary font-semibold text-sm mb-6 animate-fade-up">
                        <i class="fa-solid fa-sparkles mr-2"></i> Sistem Administrasi Belanja Modern
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 animate-fade-up delay-100">
                        Kelola Dokumen Keuangan <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Lebih Rapi & Terstruktur</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 animate-fade-up delay-200">
                        Adminris menyederhanakan pengelolaan Sub Kegiatan, Kode Rekening, data PPTK, hingga penerbitan dokumen NPD dalam satu platform profesional.
                    </p>
                    <div class="flex flex-wrap gap-4 animate-fade-up delay-300">
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="bg-primary hover:bg-blue-900 text-white px-8 py-3.5 rounded-full font-semibold transition-all transform hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/30 flex items-center">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-primary hover:bg-blue-900 text-white px-8 py-3.5 rounded-full font-semibold transition-all transform hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/30 flex items-center">
                                Mulai Sekarang
                            </a>
                        @endauth
                        <button class="bg-white border-2 border-gray-200 hover:border-primary text-gray-700 hover:text-primary px-8 py-3.5 rounded-full font-semibold transition-all transform hover:-translate-y-1 flex items-center">
                            <i class="fa-solid fa-play mr-2"></i> Demo Aplikasi
                        </button>
                    </div>
                </div>

                <div class="relative lg:h-[500px] flex justify-center items-center animate-fade-up delay-300">
                    <div class="relative w-full max-w-md animate-float">
                        <div class="bg-white rounded-2xl shadow-2xl p-6 border border-gray-100 relative z-20">
                            <div class="flex justify-between items-center mb-6 border-b pb-4">
                                <div class="w-24 h-4 bg-gray-200 rounded"></div>
                                <div class="w-8 h-8 bg-blue-100 rounded-full"></div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex gap-4">
                                    <div class="w-1/3 h-20 bg-blue-50 rounded-xl border border-blue-100"></div>
                                    <div class="w-1/3 h-20 bg-green-50 rounded-xl border border-green-100"></div>
                                    <div class="w-1/3 h-20 bg-amber-50 rounded-xl border border-amber-100"></div>
                                </div>
                                <div class="w-full h-32 bg-gray-50 rounded-xl border border-gray-100 mt-4"></div>
                            </div>
                        </div>
                        <div class="absolute -right-12 top-10 bg-white p-4 rounded-xl shadow-xl border border-gray-100 z-30 animate-float" style="animation-duration: 4s;">
                            <div class="flex items-center gap-3">
                                <div class="bg-green-100 text-green-600 p-2 rounded-lg"><i class="fa-solid fa-check"></i></div>
                                <div>
                                    <p class="text-xs text-gray-500">Status NPD</p>
                                    <p class="text-sm font-bold">Disetujui</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -left-12 bottom-10 bg-white p-4 rounded-xl shadow-xl border border-gray-100 z-30 animate-float" style="animation-duration: 5s;">
                            <div class="flex items-center gap-3">
                                <div class="bg-amber-100 text-amber-600 p-2 rounded-lg"><i class="fa-solid fa-user-tie"></i></div>
                                <div>
                                    <p class="text-xs text-gray-500">PPTK Aktif</p>
                                    <p class="text-sm font-bold">12 Pegawai</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Utama Adminris</h2>
                <p class="text-gray-600">Modul terintegrasi yang dirancang khusus untuk mempermudah tugas administrasi keuangan dan pengelolaan kegiatan instansi Anda.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-slate-50 rounded-2xl p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-white border border-transparent hover:border-gray-100 group animate-fade-up delay-100">
                    <div class="w-14 h-14 bg-blue-100 text-primary rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Sub Kegiatan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Kelola hierarki program dan sub kegiatan dengan sistem yang saling terintegrasi dan mudah dipantau.</p>
                </div>

                <div class="bg-slate-50 rounded-2xl p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-white border border-transparent hover:border-gray-100 group animate-fade-up delay-200">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-barcode"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Kode Rekening</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Pengarsipan dan pemetaan kode rekening belanja yang akurat sesuai dengan regulasi terbaru.</p>
                </div>

                <div class="bg-slate-50 rounded-2xl p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-white border border-transparent hover:border-gray-100 group animate-fade-up delay-300">
                    <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Data PPTK</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Manajemen database Pejabat Pelaksana Teknis Kegiatan lengkap dengan riwayat penugasan.</p>
                </div>

                <div class="bg-slate-50 rounded-2xl p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-white border border-transparent hover:border-gray-100 group animate-fade-up delay-400">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Dokumen NPD</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Pembuatan dan pelacakan Nota Pencairan Dana secara digital, cepat, dan siap cetak.</p>
                </div>
            </div>
        </div>
    </section>

    <footer id="tentang" class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center gap-2 mb-6">
                <i class="fa-solid fa-file-invoice-dollar text-2xl text-secondary"></i>
                <span class="font-bold text-2xl tracking-tight">Admin<span class="text-secondary">ris</span></span>
            </div>
            <p class="text-gray-400 max-w-md mx-auto mb-6 text-sm">
                Solusi profesional untuk administrasi belanja, mempermudah kinerja PPTK dan pengelola keuangan.
            </p>
            <div class="border-t border-gray-800 pt-8 mt-8 text-gray-500 text-sm flex flex-col md:flex-row justify-between items-center">
                <p>&copy; 2026 Adminris. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fade-up').forEach((el) => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    </script>
</body>
</html>
