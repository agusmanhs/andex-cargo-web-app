<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 w-full mb-6">
    <!-- Card 1: Total Kiriman Hari Ini -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] relative overflow-hidden transition-all duration-200">
        <div class="flex items-center justify-between">
            <div class="w-13 h-13 p-3 rounded-2xl bg-[#EEF4FF] text-[#1D58CD] flex items-center justify-center shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#ECFDF5] text-[#15803D]">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                12%
            </span>
        </div>
        <div class="mt-4">
            <p class="text-sm font-semibold text-slate-500">Total Kiriman Hari Ini</p>
            <p class="text-[32px] font-black text-slate-900 tracking-tight leading-none mt-1.5">{{ is_numeric($totalToday) ? number_format($totalToday, 0, ',', '.') : $totalToday }}</p>
        </div>
    </div>

    <!-- Card 2: Kiriman Dalam Proses -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] relative overflow-hidden transition-all duration-200">
        <div class="flex items-center justify-between">
            <div class="w-13 h-13 p-3 rounded-2xl bg-[#FEF2F2] text-[#DC2626] flex items-center justify-center shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-sm font-semibold text-slate-500">Kiriman Dalam Proses</p>
            <p class="text-[32px] font-black text-slate-900 tracking-tight leading-none mt-1.5">{{ is_numeric($inProcess) ? number_format($inProcess, 0, ',', '.') : $inProcess }}</p>
        </div>
    </div>

    <!-- Card 3: Kiriman Terkirim -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] relative overflow-hidden transition-all duration-200">
        <div class="flex items-center justify-between">
            <div class="w-13 h-13 p-3 rounded-2xl bg-[#ECFDF5] text-[#16A34A] flex items-center justify-center shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#ECFDF5] text-[#15803D]">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                8%
            </span>
        </div>
        <div class="mt-4">
            <p class="text-sm font-semibold text-slate-500">Kiriman Terkirim</p>
            <p class="text-[32px] font-black text-slate-900 tracking-tight leading-none mt-1.5">{{ is_numeric($delivered) ? number_format($delivered, 0, ',', '.') : $delivered }}</p>
        </div>
    </div>

    <!-- Card 4: Pendapatan Cabang -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] relative overflow-hidden transition-all duration-200"
         style="background: radial-gradient(circle at 100% 0%, rgba(192, 132, 252, 0.16) 0%, rgba(255, 255, 255, 0) 65%), #ffffff;">
        <div class="flex items-center justify-between">
            <div class="w-13 h-13 p-3 rounded-2xl bg-[#F3E8FF] text-[#9333EA] flex items-center justify-center shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-sm font-semibold text-slate-500">Pendapatan Cabang</p>
            <p class="text-[28px] font-black text-slate-900 tracking-tight leading-none mt-1.5">{{ $revenue }}</p>
        </div>
    </div>
</div>
