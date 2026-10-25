@extends('layouts.portal')

@section('title', 'Andex Cargo - Ekspedisi & Logistik Terpercaya Seluruh Nusantara')

@section('content')
<!-- Hero Section with Deep Navy Gradient & Glowing Ambient Elements -->
<section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-blue-950 text-white pt-16 pb-28 overflow-hidden">
    <!-- Ambient Background Glows -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-red-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <!-- Badge Announcement -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-800/80 border border-slate-700/80 shadow-inner">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                <span class="text-xs font-semibold text-slate-300">Ekspedisi Logistik Terpadu Nusantara</span>
                <span class="text-xs bg-red-600 text-white font-bold px-2 py-0.5 rounded-full">New App 2.0</span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                Kirim Kargo Cepat & Aman ke <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-rose-400 to-amber-400">Seluruh Indonesia</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-300 font-normal leading-relaxed max-w-2xl mx-auto">
                Spesialis rute Makassar, Jawa, Sumatera, Kalimantan, dan Indonesia Timur. Layanan kargo darat, udara, laut, serta charter armada bergaransi.
            </p>
        </div>

        <!-- Floating Quick Tool Card: Tabs Lacak Resi & Cek Tarif -->
        <div class="mt-12 max-w-4xl mx-auto" x-data="{ activeTab: 'lacak' }">
            <div class="bg-white rounded-3xl p-4 sm:p-8 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.35)] border border-slate-100 text-slate-800 relative z-20">
                <!-- Navigation Tabs -->
                <div class="flex items-center justify-center p-1.5 bg-slate-100 rounded-2xl max-w-md mx-auto mb-8 border border-slate-200/80">
                    <button 
                        @click="activeTab = 'lacak'" 
                        :class="activeTab === 'lacak' ? 'bg-white text-red-600 shadow-sm font-bold' : 'text-slate-600 font-semibold hover:text-slate-900'"
                        class="flex-1 py-3 px-6 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Lacak Resi (AWB)
                    </button>
                    <button 
                        @click="activeTab = 'tarif'" 
                        :class="activeTab === 'tarif' ? 'bg-white text-red-600 shadow-sm font-bold' : 'text-slate-600 font-semibold hover:text-slate-900'"
                        class="flex-1 py-3 px-6 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Cek Tarif Ongkir
                    </button>
                </div>

                <!-- Tab 1: Lacak Resi -->
                <div x-show="activeTab === 'lacak'" class="space-y-4">
                    <form action="{{ route('track') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <input 
                                type="text" 
                                name="resi" 
                                placeholder="Masukkan nomor resi Andex Cargo (misal: UPG2610339)" 
                                required
                                class="w-full pl-12 pr-4 py-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 font-medium text-base focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500 transition-all">
                        </div>
                        <button 
                            type="submit" 
                            class="px-8 py-4 rounded-2xl bg-gradient-to-r from-red-600 via-red-500 to-rose-600 text-white font-bold text-base shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2">
                            <span>Lacak Sekarang</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>

                    <!-- Sample Quick Resi Chips -->
                    <div class="flex flex-wrap items-center gap-2 pt-2 text-xs text-slate-500">
                        <span class="font-medium">Coba Resi Demo:</span>
                        <a href="{{ route('track', ['resi' => 'UPG2610339']) }}" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-red-50 hover:text-red-600 font-mono font-medium border border-slate-200/60 transition-colors">UPG2610339</a>
                        <a href="{{ route('track', ['resi' => 'SUB2610036']) }}" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-red-50 hover:text-red-600 font-mono font-medium border border-slate-200/60 transition-colors">SUB2610036</a>
                        <a href="{{ route('track', ['resi' => 'UPG2610342']) }}" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-red-50 hover:text-red-600 font-mono font-medium border border-slate-200/60 transition-colors">UPG2610342</a>
                    </div>
                </div>

                <!-- Tab 2: Cek Tarif Ongkir (Interactive AJAX) -->
                <div x-show="activeTab === 'tarif'" x-cloak x-data="tariffCalculator()" id="cek-tarif" class="space-y-6">
                    <form @submit.prevent="checkTariff" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Origin City -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Kota Asal</label>
                            <select x-model="fromCity" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="7371" selected>KOTA MAKASSAR (Hub Utama)</option>
                                <option value="3171">KOTA JAKARTA PUSAT</option>
                                <option value="3578">KOTA SURABAYA</option>
                                <option value="3273">KOTA BANDUNG</option>
                                <option value="7171">KOTA MANADO</option>
                            </select>
                        </div>

                        <!-- Destination City -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Kota Tujuan</label>
                            <select x-model="toCity" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="3578" selected>KOTA SURABAYA</option>
                                <option value="3171">KOTA JAKARTA PUSAT</option>
                                <option value="3273">KOTA BANDUNG</option>
                                <option value="7371">KOTA MAKASSAR</option>
                                <option value="7471">KOTA KENDARI</option>
                                <option value="7271">KOTA PALU</option>
                                <option value="7171">KOTA MANADO</option>
                            </select>
                        </div>

                        <!-- Weight -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Estimasi Berat (Kg)</label>
                            <div class="flex gap-2">
                                <input 
                                    type="number" 
                                    x-model="weight" 
                                    min="1" 
                                    step="1" 
                                    required 
                                    class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 font-medium text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                                <button 
                                    type="submit" 
                                    :disabled="loading"
                                    class="px-5 py-3.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-sm shadow-md transition-colors flex items-center justify-center">
                                    <span x-show="!loading">Hitung</span>
                                    <span x-show="loading" x-cloak>...</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Rate Result Cards -->
                    <div x-show="results.length > 0" x-cloak class="space-y-3 pt-4 border-t border-slate-100">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Hasil Perhitungan Tarif:</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <template x-for="item in results" :key="item.service_name">
                                <div class="p-5 rounded-2xl border-2 border-slate-100 hover:border-blue-500/50 bg-gradient-to-br from-white to-slate-50/50 shadow-sm transition-all duration-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200/50" x-text="item.service_type"></span>
                                            <h4 class="text-base font-bold text-slate-900 mt-1" x-text="item.service_name"></h4>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs text-slate-500">Total Biaya</div>
                                            <div class="text-xl font-extrabold text-red-600" x-text="item.total_cost_formatted"></div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center text-xs text-slate-600 pt-3 border-t border-slate-100">
                                        <span>Tarif: <strong x-text="item.price_per_kg_formatted"></strong> /Kg</span>
                                        <span>Estimasi: <strong class="text-slate-900" x-text="item.estimated_time"></strong></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-show="errorMessage" x-cloak class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs">
                        <span x-text="errorMessage"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- ELEVATED FEATURE / SERVICE CARDS (HIGHLIGHT) -->
<!-- ========================================== -->
<section id="layanan" class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-red-50 text-red-600 text-xs font-extrabold uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Layanan Logistik Terlengkap
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Solusi Pengiriman Terbaik untuk Setiap Kebutuhan Anda
            </h2>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">
                Dirancang khusus dengan standar operasional ketat, transparansi tarif, dan jaminan keamanan paket hingga ke tangan penerima.
            </p>
        </div>

        <!-- 4 Elevated Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- CARD 1: Kargo Darat & Trucking -->
            <div class="card-elevated group relative rounded-3xl bg-white border border-slate-200/90 p-7 shadow-[0_10px_35px_-10px_rgba(30,58,138,0.07)] hover:border-blue-500/40 flex flex-col justify-between overflow-hidden">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-600 to-indigo-600"></div>

                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200/60">
                            Paling Populer
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-2">Trucking Darat</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">
                        Pengiriman kargo darat rute antar-kota dan antar-provinsi. Armada CDD, Fuso, hingga Tronton siap charter maupun LTL.
                    </p>

                    <!-- Feature Points -->
                    <ul class="space-y-2.5 text-xs text-slate-600 mb-6">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Kapasitas muatan hingga 25 Ton
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Layanan Door to Door Pickup
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Tarif ekonomis per kilogram
                        </li>
                    </ul>
                </div>

                <!-- Footer Link -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-blue-600 group-hover:text-blue-700">Mulai dari Rp 3.500/Kg</span>
                    <a href="#cek-tarif" class="text-xs font-semibold text-slate-400 group-hover:text-slate-900 flex items-center gap-1">
                        Cek Tarif <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- CARD 2: Express Udara -->
            <div class="card-elevated group relative rounded-3xl bg-white border border-slate-200/90 p-7 shadow-[0_10px_35px_-10px_rgba(30,58,138,0.07)] hover:border-red-500/40 flex flex-col justify-between overflow-hidden">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-600 to-rose-600"></div>

                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-600 to-rose-700 text-white flex items-center justify-center shadow-lg shadow-red-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-bold border border-red-200/60">
                            1 - 2 Hari Sampai
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-2">Express Udara</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">
                        Layanan pengiriman kargo via jalur penerbangan komersial & kargo reguler untuk kebutuhan mendesak dan bernilai tinggi.
                    </p>

                    <!-- Feature Points -->
                    <ul class="space-y-2.5 text-xs text-slate-600 mb-6">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Penerbangan Harian (Daily Flight)
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Prioritas Handling di Bandara
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Tracking Real-time Setiap Titik
                        </li>
                    </ul>
                </div>

                <!-- Footer Link -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-red-600 group-hover:text-red-700">Garansi Kilat</span>
                    <a href="#cek-tarif" class="text-xs font-semibold text-slate-400 group-hover:text-slate-900 flex items-center gap-1">
                        Cek Tarif <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- CARD 3: Kargo Laut (Sea Cargo) -->
            <div class="card-elevated group relative rounded-3xl bg-white border border-slate-200/90 p-7 shadow-[0_10px_35px_-10px_rgba(30,58,138,0.07)] hover:border-cyan-500/40 flex flex-col justify-between overflow-hidden">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-cyan-500 to-sky-600"></div>

                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-600 to-sky-700 text-white flex items-center justify-center shadow-lg shadow-cyan-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-cyan-50 text-cyan-700 text-xs font-bold border border-cyan-200/60">
                            Tonase Besar
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-2">Kargo Laut & FCL</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">
                        Solusi terbaik pengiriman barang berat, mesin industri, komoditas, dan material proyek dengan tarif paling efisien.
                    </p>

                    <!-- Feature Points -->
                    <ul class="space-y-2.5 text-xs text-slate-600 mb-6">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            LCL (Kubikasi) & FCL (Kontainer)
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Jadwal Kapal Cepat Pelni & Kargo
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Penanganan Alat Berat & Kendaraan
                        </li>
                    </ul>
                </div>

                <!-- Footer Link -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-cyan-600 group-hover:text-cyan-700">Harga Per M³ / Kg</span>
                    <a href="#cek-tarif" class="text-xs font-semibold text-slate-400 group-hover:text-slate-900 flex items-center gap-1">
                        Cek Tarif <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- CARD 4: Corporate B2B & Kontrak -->
            <div class="card-elevated group relative rounded-3xl bg-white border border-slate-200/90 p-7 shadow-[0_10px_35px_-10px_rgba(30,58,138,0.07)] hover:border-emerald-500/40 flex flex-col justify-between overflow-hidden">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 to-teal-600"></div>

                <div>
                    <!-- Badge & Icon -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/60">
                            Fasilitas Tempo
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-2">Corporate & B2B</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">
                        Kemitraan khusus perusahaan, pabrik, distributor, dan e-commerce dengan sistem tagihan bulanan (invoice tempo).
                    </p>

                    <!-- Feature Points -->
                    <ul class="space-y-2.5 text-xs text-slate-600 mb-6">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Dedicated Account Manager (CS 24 Jam)
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Jadwal Pickup Rutin di Gudang Anda
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Diskon Volume & Kontrak Khusus
                        </li>
                    </ul>
                </div>

                <!-- Footer Link -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-emerald-600 group-hover:text-emerald-700">Invoice Net 14/30</span>
                    <a href="https://wa.me/6281234567890?text=Halo%20Andex%20Cargo,%20saya%20tertarik%20kerjasama%20Corporate%20B2B" target="_blank" class="text-xs font-semibold text-slate-400 group-hover:text-slate-900 flex items-center gap-1">
                        Hubungi Kami <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- STAT COUNTERS & NETWORK SECTION -->
<!-- ========================================== -->
<section class="py-20 bg-slate-900 text-white relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 bg-[radial-gradient(#1e3a8a_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            <!-- Stat 1 -->
            <div class="p-6 sm:p-8 rounded-3xl bg-slate-800/80 border border-slate-700/80 backdrop-blur-md shadow-xl text-center space-y-2 card-elevated">
                <div class="text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400">
                    20+
                </div>
                <div class="text-base font-bold text-white">Kantor Cabang & Hub</div>
                <div class="text-xs text-slate-400">Makassar, Jakarta, Surabaya, Manado, Kendari, dll</div>
            </div>

            <!-- Stat 2 -->
            <div class="p-6 sm:p-8 rounded-3xl bg-slate-800/80 border border-slate-700/80 backdrop-blur-md shadow-xl text-center space-y-2 card-elevated">
                <div class="text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">
                    520+
                </div>
                <div class="text-base font-bold text-white">Kota & Kabupaten</div>
                <div class="text-xs text-slate-400">Jangkauan pengiriman hingga pelosok kecamatan</div>
            </div>

            <!-- Stat 3 -->
            <div class="p-6 sm:p-8 rounded-3xl bg-slate-800/80 border border-slate-700/80 backdrop-blur-md shadow-xl text-center space-y-2 card-elevated">
                <div class="text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">
                    99.8%
                </div>
                <div class="text-base font-bold text-white">Ketepatan Waktu</div>
                <div class="text-xs text-slate-400">On-time delivery dengan sistem manifest presisi</div>
            </div>

            <!-- Stat 4 -->
            <div class="p-6 sm:p-8 rounded-3xl bg-slate-800/80 border border-slate-700/80 backdrop-blur-md shadow-xl text-center space-y-2 card-elevated">
                <div class="text-3xl sm:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-400">
                    10.000+
                </div>
                <div class="text-base font-bold text-white">Ton Kargo/Bulan</div>
                <div class="text-xs text-slate-400">Dipercaya oleh ribuan pebisnis & korporat</div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- CALL TO ACTION BANNER -->
<!-- ========================================== -->
<section class="py-20 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 p-8 sm:p-14 text-white shadow-2xl overflow-hidden border border-slate-800">
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-red-600/30 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl space-y-4">
                <span class="px-3 py-1 rounded-full bg-red-600/30 text-red-400 text-xs font-bold uppercase tracking-wider border border-red-500/30">
                    Butuh Penawaran Khusus?
                </span>
                <h3 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                    Konsultasikan Pengiriman Kargo & Kebutuhan Logistik Anda Sekarang
                </h3>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Tim Customer Support kami siap memberikan rekomendasi rute tercepat dan tarif paling hemat untuk bisnis Anda.
                </p>

                <div class="pt-4 flex flex-wrap items-center gap-4">
                    <a href="https://wa.me/6281234567890?text=Halo%20Andex%20Cargo,%20saya%20ingin%20konsultasi%20pengiriman%20kargo" target="_blank" class="px-7 py-3.5 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-bold text-sm shadow-lg shadow-red-600/30 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <span>Chat via WhatsApp</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('branches') }}" class="px-7 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm border border-white/20 transition-all">
                        Lihat Lokasi Gudang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function tariffCalculator() {
        return {
            fromCity: '7371', // Makassar
            toCity: '3578',   // Surabaya
            weight: 10,
            loading: false,
            results: [],
            errorMessage: '',
            async checkTariff() {
                this.loading = true;
                this.results = [];
                this.errorMessage = '';

                try {
                    const response = await fetch('{{ route("api.tariff") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            from: this.fromCity,
                            to: this.toCity,
                            weight: this.weight
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.results = data.data;
                    } else {
                        this.errorMessage = data.message || 'Tarif tidak ditemukan.';
                    }
                } catch (error) {
                    this.errorMessage = 'Terjadi kesalahan saat menghitung tarif. Silakan coba lagi.';
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endpush
