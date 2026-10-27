<div class="min-h-screen flex flex-col lg:flex-row w-full font-['Outfit',sans-serif] bg-white selection:bg-[#c5161d] selection:text-white">
    
    <!-- LEFT PANEL: OPERATIONS COMMAND CENTER SHOWCASE -->
    <div class="w-full lg:w-[52%] xl:w-[55%] min-h-screen bg-[#070e20] text-white p-7 lg:p-12 xl:p-14 flex flex-col justify-between relative overflow-hidden">
        <!-- Dot-matrix background texture -->
        <div class="absolute inset-0 pointer-events-none opacity-40" style="background-image: radial-gradient(#334155 1.2px, transparent 1.2px); background-size: 24px 24px;"></div>
        
        <!-- Ambient radial glow lights -->
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(29, 88, 205, 0.35) 0%, transparent 70%);"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full pointer-events-none" style="background: radial-gradient(circle, rgba(139, 92, 246, 0.22) 0%, transparent 70%);"></div>

        <!-- Top Header: Node & Live Status -->
        <div class="relative z-10 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-950/80 border border-blue-500/30 flex items-center justify-center text-blue-400 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
                <div>
                    <div class="font-black text-sm tracking-wider uppercase text-white">ANDEX CORE GRID</div>
                    <div class="font-mono text-[10px] tracking-widest text-slate-400 uppercase">NODE: CGK-HUB-CENTRAL #01</div>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 border border-emerald-500/40 bg-emerald-950/70 px-3 py-1 rounded-full text-[10px] font-mono font-bold text-emerald-400 tracking-wider shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                SEMUA HUB BEROPERASI NORMAL
            </div>
        </div>

        <!-- Middle Content: Hero Headline & Glassmorphism Showcase Card -->
        <div class="relative z-10 my-8">
            <!-- Eyebrow Pill -->
            <div class="inline-flex items-center gap-2 border border-white/10 bg-white/5 backdrop-blur-md px-3.5 py-1 rounded-full text-xs text-slate-300 font-medium mb-4 shadow-sm">
                <svg class="w-3.5 h-3.5 text-rose-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l2.4 7.4h7.6l-6.2 4.5 2.4 7.4-6.2-4.5-6.2 4.5 2.4-7.4-6.2-4.5h7.6z" />
                </svg>
                Sistem Operasional Logistik Terpadu
            </div>

            <!-- Headline -->
            <h1 class="text-3xl sm:text-4xl lg:text-[2.65rem] font-black text-white leading-[1.16] tracking-tight mb-3">
                Infrastruktur Kargo Cepat & Presisi Seluruh Nusantara.
            </h1>

            <!-- Subtitle -->
            <p class="text-slate-400 text-sm lg:text-[15px] leading-relaxed max-w-xl mb-6 font-normal">
                Kelola manifes kargo udara, pelayaran ekspres, armada darat terpadu, dan monitoring real-time dalam satu portal terenkripsi.
            </p>

            <!-- Glassmorphism SLA & Logistics Stats Card -->
            <div class="bg-[#0f172a]/80 backdrop-blur-xl border border-white/10 rounded-2xl p-5 lg:p-6 shadow-2xl relative overflow-hidden">
                <!-- Header inside card -->
                <div class="flex items-center justify-between pb-4 border-b border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke-width="2" />
                                <circle cx="12" cy="12" r="5" stroke-width="2" />
                                <circle cx="12" cy="12" r="1" fill="currentColor" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">AKURASI PENGIRIMAN (SLA)</div>
                            <div class="text-base lg:text-lg font-black text-white tracking-tight">99.98% On-Time Precision</div>
                        </div>
                    </div>
                    <span class="border border-emerald-500/40 bg-emerald-950/70 text-emerald-400 text-[11px] font-mono font-bold px-2.5 py-0.5 rounded-full">
                        Real-time
                    </span>
                </div>

                <!-- 3 Grid Metric Sub-Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 my-4">
                    <!-- Metric 1: Kargo Udara -->
                    <div class="bg-slate-900/70 border border-white/5 rounded-xl p-3.5">
                        <div class="flex items-center gap-2 text-cyan-400 text-xs font-semibold mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kargo Udara
                        </div>
                        <div class="text-lg font-black text-white">420+ Ton</div>
                        <div class="text-[11px] text-emerald-400 font-bold mt-0.5">↑ 12.4% vs kemarin</div>
                    </div>

                    <!-- Metric 2: Armada Aktif -->
                    <div class="bg-slate-900/70 border border-white/5 rounded-xl p-3.5">
                        <div class="flex items-center gap-2 text-amber-400 text-xs font-semibold mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1" />
                            </svg>
                            Armada Aktif
                        </div>
                        <div class="text-lg font-black text-white">1,840 Truk</div>
                        <div class="text-[11px] text-slate-400 font-medium mt-0.5">150+ Kota Aktif</div>
                    </div>

                    <!-- Metric 3: Manifes Harian -->
                    <div class="bg-slate-900/70 border border-white/5 rounded-xl p-3.5">
                        <div class="flex items-center gap-2 text-rose-400 text-xs font-semibold mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Manifes Harian
                        </div>
                        <div class="text-lg font-black text-white">98,420 AWB</div>
                        <div class="text-[11px] text-emerald-400 font-bold mt-0.5">Tersinkronisasi</div>
                    </div>
                </div>

                <!-- Capacity Progress Bar -->
                <div>
                    <div class="flex items-center justify-between text-xs mb-1.5 font-mono">
                        <span class="text-slate-400">Kapasitas Kapal & Cargo Line</span>
                        <span class="text-white font-bold">94.8% Terpenuhi</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-slate-800 overflow-hidden">
                        <div class="h-full rounded-full" style="width: 94.8%; background: linear-gradient(90deg, #38bdf8 0%, #818cf8 50%, #f43f5e 100%);"></div>
                    </div>
                </div>
            </div>

            <!-- 2 Trust & Security Badges -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                <div class="bg-slate-900/50 border border-white/5 rounded-xl p-3 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">ISO 27001 & ISO 9001</div>
                        <div class="text-[11px] text-slate-400">Standar Keamanan Informasi Internasional</div>
                    </div>
                </div>

                <div class="bg-slate-900/50 border border-white/5 rounded-xl p-3 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-white">Enkripsi 256-Bit TLS</div>
                        <div class="text-[11px] text-slate-400">Perlindungan Data Transaksi Tingkat Finansial</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Footer -->
        <div class="relative z-10 flex flex-wrap items-center justify-between text-xs text-slate-500 pt-4 border-t border-white/5 gap-2">
            <div>© 2026 PT Andex Cargo Indonesia • Hak Cipta Dilindungi</div>
            <div class="flex items-center gap-4">
                <span class="text-emerald-400 flex items-center gap-1.5 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Status Server 100%
                </span>
                <span class="font-mono text-slate-400">v4.8.2-Enterprise</span>
            </div>
        </div>
    </div>


    <!-- RIGHT PANEL: CLEAN ENTERPRISE LOGIN FORM -->
    <div class="w-full lg:w-[48%] xl:w-[45%] min-h-screen bg-white flex flex-col justify-between p-6 sm:p-10 lg:p-12 xl:p-14 relative">
        
        <!-- Top Action: Helpdesk Button -->
        <div class="flex justify-end">
            <a href="https://wa.me/628114442321" target="_blank" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-slate-200/90 text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition-all hover:border-slate-300">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Bantuan Helpdesk
            </a>
        </div>

        <!-- Form Center Box -->
        <div class="max-w-md w-full mx-auto my-auto py-4">
            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="Andex Cargo" class="h-12 lg:h-14 mx-auto object-contain">
            </div>

            <!-- Portal Pill -->
            <div class="text-center mb-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-slate-100 text-slate-600 border border-slate-200/60">
                    <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    PORTAL MASUK TERPADU
                </span>
            </div>

            <!-- Heading -->
            <h2 class="text-2xl lg:text-[1.75rem] font-black text-slate-900 text-center tracking-tight">
                Masuk ke Akun Anda
            </h2>

            <!-- Subtitle -->
            <p class="text-xs lg:text-sm text-slate-500 text-center mt-1 mb-5 leading-normal max-w-sm mx-auto">
                Akses portal operasional cabang, sistem agen resmi, dan analitik logistik terpadu.
            </p>

            <!-- Segmented Role Tabs (Visual Selector) -->
            <div class="bg-slate-100 p-1 rounded-xl flex items-center justify-between text-xs font-semibold mb-5">
                <button type="button" class="flex-1 py-1.5 rounded-lg bg-white shadow-sm text-slate-900 font-bold transition-all text-center">
                    Kantor Cabang
                </button>
                <button type="button" class="flex-1 py-1.5 rounded-lg text-slate-500 hover:text-slate-900 transition-all text-center">
                    Mitra Agen
                </button>
                <button type="button" class="flex-1 py-1.5 rounded-lg text-slate-500 hover:text-slate-900 transition-all text-center">
                    Korporat & Klien
                </button>
            </div>

            <!-- Livewire / Filament Login Form -->
            <x-filament-panels::form id="form" wire:submit="authenticate" class="space-y-4">
                {{ $this->form }}

                <!-- TLS 1.3 Badge below remember me -->
                <div class="flex items-center justify-end -mt-2 mb-2">
                    <span class="text-[11px] font-mono text-slate-400 flex items-center gap-1">
                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        TLS 1.3 Terenkripsi
                    </span>
                </div>

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </x-filament-panels::form>

            <!-- Divider -->
            <div class="relative my-6 text-center">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <span class="relative bg-white px-3 text-[10px] font-bold tracking-widest text-slate-400 uppercase">
                    ATAU AUTENTIKASI INSTAN
                </span>
            </div>

            <!-- SSO Buttons -->
            <div class="grid grid-cols-2 gap-3">
                <button type="button" onclick="alert('Fitur SSO Google Workspace terintegrasi dengan domain @andexcargo.id')" class="border border-slate-200/90 rounded-xl py-2.5 px-3 flex items-center justify-center gap-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm">
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.4 9 5 12 5z" />
                        <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.7-.2-2.3H12v4.6h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.9z" />
                        <path fill="#FBBC05" d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.3s.2-1.6.4-2.3L1.9 7.3C.7 9.7 0 10.8 0 12.5s.7 2.8 1.9 5.2l3.7-2.9z" />
                        <path fill="#34A853" d="M12 24c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2.4-6.4-5.2L1.9 17C3.7 20.7 7.5 24 12 24z" />
                    </svg>
                    Google Workspace
                </button>

                <button type="button" onclick="alert('SAML / SSO Pusat khusus untuk jaringan internal kantor pusat.')" class="border border-slate-200/90 rounded-xl py-2.5 px-3 flex items-center justify-center gap-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    SAML / SSO Pusat
                </button>
            </div>

            <!-- Activation / Help Callout -->
            <div class="bg-blue-50/70 border border-blue-200/70 rounded-xl p-3.5 flex items-start gap-3 mt-6 text-xs text-slate-600 leading-relaxed">
                <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <div>
                    Belum memiliki akun mitra atau kredensial cabang? Silakan hubungi <strong class="text-slate-800">Head Office Administrator</strong> untuk aktivasi peran resmi.
                </div>
            </div>
        </div>

        <!-- Right Footer -->
        <div class="flex flex-wrap items-center justify-between text-xs text-slate-500 pt-4 border-t border-slate-100 gap-2">
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>PT Andex Cargo Indonesia • Enterprise Gate</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400">
                <a href="#" class="hover:text-slate-700 transition-colors">Privasi</a>
                <span>•</span>
                <a href="#" class="hover:text-slate-700 transition-colors">Syarat & Ketentuan</a>
                <span>•</span>
                <a href="#" class="hover:text-slate-700 transition-colors">Kontak IT</a>
            </div>
        </div>

    </div>
</div>
