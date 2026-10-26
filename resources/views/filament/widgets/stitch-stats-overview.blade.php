<div class="stitch-stats-container">
    <!-- Card 1: Total Kiriman Hari Ini -->
    <div class="stitch-stat-card stitch-card-blue">
        <div class="stitch-card-header">
            <div class="stitch-icon-box stitch-icon-box-blue">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <span class="stitch-badge stitch-badge-green">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                +12%
            </span>
        </div>
        <div>
            <div class="stitch-card-label">Total Kiriman Hari Ini</div>
            <div class="stitch-card-value">{{ is_numeric($totalToday) ? number_format($totalToday, 0, ',', '.') : $totalToday }}</div>
        </div>
        <div class="stitch-card-footer">
            <span class="stitch-card-footer-dot bg-blue-500"></span>
            <span>Update real-time kargo cabang</span>
        </div>
    </div>

    <!-- Card 2: Kiriman Dalam Proses -->
    <div class="stitch-stat-card stitch-card-amber">
        <div class="stitch-card-header">
            <div class="stitch-icon-box stitch-icon-box-amber">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
            </div>
            <span class="stitch-badge stitch-badge-amber">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Aktif
            </span>
        </div>
        <div>
            <div class="stitch-card-label">Kiriman Dalam Proses</div>
            <div class="stitch-card-value">{{ is_numeric($inProcess) ? number_format($inProcess, 0, ',', '.') : $inProcess }}</div>
        </div>
        <div class="stitch-card-footer">
            <span class="stitch-card-footer-dot bg-amber-500"></span>
            <span>Transit, Hub & Kurir Antar</span>
        </div>
    </div>

    <!-- Card 3: Kiriman Terkirim -->
    <div class="stitch-stat-card stitch-card-green">
        <div class="stitch-card-header">
            <div class="stitch-icon-box stitch-icon-box-green">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="stitch-badge stitch-badge-green">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
                98.2% Sukses
            </span>
        </div>
        <div>
            <div class="stitch-card-label">Kiriman Terkirim (POD)</div>
            <div class="stitch-card-value">{{ is_numeric($delivered) ? number_format($delivered, 0, ',', '.') : $delivered }}</div>
        </div>
        <div class="stitch-card-footer">
            <span class="stitch-card-footer-dot bg-emerald-500"></span>
            <span>Tanda terima & foto terverifikasi</span>
        </div>
    </div>

    <!-- Card 4: Pendapatan Cabang -->
    <div class="stitch-stat-card stitch-card-purple" style="background: radial-gradient(circle at 100% 0%, rgba(139, 92, 246, 0.12) 0%, #ffffff 65%) !important;">
        <div class="stitch-card-header">
            <div class="stitch-icon-box stitch-icon-box-purple">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="stitch-badge stitch-badge-purple">
                Tahun 2026
            </span>
        </div>
        <div>
            <div class="stitch-card-label">Pendapatan Cabang</div>
            <div class="stitch-card-value-currency">{{ $revenue }}</div>
        </div>
        <div class="stitch-card-footer">
            <span class="stitch-card-footer-dot bg-purple-500"></span>
            <span>Akumulasi transaksi kas & tempo</span>
        </div>
    </div>
</div>
