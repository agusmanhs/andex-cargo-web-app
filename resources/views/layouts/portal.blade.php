<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Andex Cargo - Ekspedisi & Logistik Terpercaya Seluruh Nusantara')</title>
    <meta name="description" content="Jasa pengiriman kargo darat, laut, dan udara terbaik di Indonesia. Cek resi dan hitung tarif pengiriman ke seluruh pelosok nusantara dengan cepat dan aman.">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS (CDN + Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        andex: {
                            blue: '#1E3A8A',
                            dark: '#0F172A',
                            red: '#DC2626',
                            sky: '#0284C7',
                        }
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .card-elevated {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-elevated:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(30, 58, 138, 0.15);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-red-500 selection:text-white" x-data="{ mobileMenu: false }">

    <!-- Top Info Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    CS Hotline: <strong class="text-white">0812-3456-7890</strong>
                </span>
                <span class="hidden md:inline-block text-slate-600">|</span>
                <span class="hidden md:flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Hub Utama: Ruko Pasar Grosir Daya Blok C2 No 15, Makassar
                </span>
            </div>
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1 text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    Operasional Aktif 24/7
                </span>
                <a href="{{ url('/admin') }}" class="text-slate-200 hover:text-white font-medium flex items-center gap-1">
                    Masuk Portal Internal &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-600 via-red-500 to-rose-700 flex items-center justify-center text-white shadow-lg shadow-red-500/30 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1">
                            <span class="text-2xl font-extrabold tracking-tight text-slate-900">ANDEX</span>
                            <span class="text-2xl font-black text-red-600">CARGO</span>
                        </div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 block">Ekspedisi & Logistik Terpadu</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-700 hover:text-red-600 transition-colors {{ request()->routeIs('home') ? 'text-red-600' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('track') }}" class="text-sm font-semibold text-slate-700 hover:text-red-600 transition-colors {{ request()->routeIs('track') ? 'text-red-600' : '' }}">
                        Lacak Resi (AWB)
                    </a>
                    <a href="{{ route('home') }}#cek-tarif" class="text-sm font-semibold text-slate-700 hover:text-red-600 transition-colors">
                        Cek Tarif Ongkir
                    </a>
                    <a href="{{ route('home') }}#layanan" class="text-sm font-semibold text-slate-700 hover:text-red-600 transition-colors">
                        Layanan Kargo
                    </a>
                    <a href="{{ route('branches') }}" class="text-sm font-semibold text-slate-700 hover:text-red-600 transition-colors {{ request()->routeIs('branches') ? 'text-red-600' : '' }}">
                        Jaringan Cabang
                    </a>
                </nav>

                <!-- Action CTA -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ url('/admin/login') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 shadow-md shadow-red-500/25 hover:shadow-lg hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk Sistem
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu" x-cloak class="md:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block py-2 text-base font-semibold text-slate-800 hover:text-red-600">Beranda</a>
            <a href="{{ route('track') }}" class="block py-2 text-base font-semibold text-slate-800 hover:text-red-600">Lacak Resi</a>
            <a href="{{ route('home') }}#cek-tarif" class="block py-2 text-base font-semibold text-slate-800 hover:text-red-600">Cek Tarif</a>
            <a href="{{ route('home') }}#layanan" class="block py-2 text-base font-semibold text-slate-800 hover:text-red-600">Layanan Kargo</a>
            <a href="{{ route('branches') }}" class="block py-2 text-base font-semibold text-slate-800 hover:text-red-600">Jaringan Cabang</a>
            <div class="pt-4 border-t border-slate-100">
                <a href="{{ url('/admin') }}" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl font-bold text-white bg-red-600 text-center shadow-md">
                    Masuk Portal Internal
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 pt-16 pb-12 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-900">
                <!-- Col 1: About -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-red-600 flex items-center justify-center text-white font-black text-xl">
                            A
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">ANDEX <span class="text-red-500">CARGO</span></span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400 pr-6">
                        Penyedia layanan ekspedisi kargo darat, laut, dan udara terpercaya. Menghubungkan Makassar, Jawa, Sumatera, Kalimantan, dan seluruh penjuru Indonesia dengan komitmen cepat, aman, dan harga bersahabat.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-xs font-semibold text-slate-300">
                            🚚 Armada Trucking Lengkap
                        </span>
                        <span class="px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-xs font-semibold text-slate-300">
                            🛡️ Asuransi & Garansi
                        </span>
                    </div>
                </div>

                <!-- Col 2: Hub Utama Makassar -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Gudang Hub Makassar</h4>
                    <p class="text-xs text-slate-400 leading-relaxed mb-3">
                        Ruko Pasar Grosir Daya Modern Blok C2 No 15 Daya Makassar, Sulawesi Selatan 90242
                    </p>
                    <p class="text-xs text-slate-300">
                        Telp: <strong class="text-white">(0411) 890-XXXX</strong><br>
                        WA: <strong class="text-emerald-400">0812-3456-7890</strong>
                    </p>
                </div>

                <!-- Col 3: Cabang Jakarta & Surabaya -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Cabang Hub Jawa</h4>
                    <div class="space-y-3 text-xs">
                        <div>
                            <strong class="text-slate-200 block">Hub Jakarta:</strong>
                            <span class="text-slate-400">Jl. Delima Raya No 13A, Duren Sawit, Jakarta Timur</span>
                        </div>
                        <div>
                            <strong class="text-slate-200 block">Hub Surabaya:</strong>
                            <span class="text-slate-400">Ruko 21 Klampis Blok G No. 14, Jl. Arief Rahman Hakim, Surabaya</span>
                        </div>
                    </div>
                </div>

                <!-- Col 4: Tautan Cepat -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Tautan</h4>
                    <ul class="space-y-2 text-xs font-medium">
                        <li><a href="{{ route('track') }}" class="hover:text-red-400 transition-colors">Lacak Pengiriman (AWB)</a></li>
                        <li><a href="{{ route('home') }}#cek-tarif" class="hover:text-red-400 transition-colors">Simulasi Ongkos Kirim</a></li>
                        <li><a href="{{ route('branches') }}" class="hover:text-red-400 transition-colors">Daftar Semua 20 Cabang</a></li>
                        <li><a href="{{ url('/admin') }}" class="text-red-400 hover:text-red-300 font-bold">Portal Manajemen</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} PT. Andex Cargo Indonesia. Seluruh hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-slate-400">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-slate-400">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-slate-400">Klaim Pengiriman</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
