@extends('layouts.portal')

@section('title', 'Lacak Resi Pengiriman - Andex Cargo')

@section('content')
<div class="bg-slate-100/70 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Top Tracking Search Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80">
            <div class="max-w-2xl mx-auto text-center space-y-2 mb-6">
                <span class="px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold uppercase tracking-wider">
                    Real-time Tracking
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Lacak Status Kiriman Kargo Anda
                </h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    Masukkan nomor resi (AWB) Andex Cargo untuk mengetahui riwayat dan posisi paket terkini.
                </p>
            </div>

            <form action="{{ route('track') }}" method="GET" class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input 
                        type="text" 
                        name="resi" 
                        value="{{ $trackingNumber }}"
                        placeholder="Contoh: UPG2610339" 
                        required
                        class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-slate-900 font-medium text-base focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all">
                </div>
                <button 
                    type="submit" 
                    class="px-8 py-3.5 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-bold text-base shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>Lacak Resi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>
        </div>

        @if($shipment)
            <!-- Shipment Overview Hero Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
                <!-- Top Row: AWB + Status Badge -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Nomor Resi / AWB</span>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-2xl sm:text-3xl font-black text-slate-900 font-mono tracking-tight">{{ $shipment->tracking_number }}</span>
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wide
                                {{ $shipment->status === 'DELIVERED' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-blue-100 text-blue-800 border border-blue-300' }}">
                                {{ $shipment->status === 'DELIVERED' ? '✓ Terkirim' : ($shipment->status === 'IN_TRANSIT' ? '🚚 Dalam Perjalanan' : '📦 ' . $shipment->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button onclick="window.print()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Cetak Bukti Resi
                        </button>
                    </div>
                </div>

                <!-- Step Progress Bar -->
                <div>
                    <div class="flex justify-between text-xs font-semibold text-slate-600 mb-2">
                        <span>Gudang Asal (Makassar)</span>
                        <span>Manifest Dispatch</span>
                        <span>Transit Antar-Hub</span>
                        <span>Hub Tujuan</span>
                        <span>Terkirim</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden p-0.5 border border-slate-200">
                        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-500 h-full rounded-full transition-all duration-700 ease-out" style="width: {{ $progressPercent }}%"></div>
                    </div>
                </div>

                <!-- 4 Metrics Bar -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-slate-100">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-500 block">Rute Pengiriman</span>
                        <strong class="text-sm font-bold text-slate-900 mt-0.5 block">
                            {{ $shipment->origin_city ?: ($shipment->originBranch->name ?? 'Makassar') }} &rarr; {{ $shipment->destination_city ?: 'Surabaya' }}
                        </strong>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-500 block">Layanan Ekspedisi</span>
                        <strong class="text-sm font-bold text-slate-900 mt-0.5 block">
                            {{ $shipment->service->name ?? 'Reguler Cargo' }}
                        </strong>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-500 block">Berat & Koli</span>
                        <strong class="text-sm font-bold text-slate-900 mt-0.5 block">
                            {{ number_format($shipment->actual_weight ?: $shipment->chargeable_weight, 1) }} Kg ({{ $shipment->total_colly }} Koli)
                        </strong>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-500 block">Metode Pembayaran</span>
                        <strong class="text-sm font-bold text-slate-900 mt-0.5 block">
                            {{ $shipment->payment_type }} ({{ $shipment->payment_status === 'PAID' ? 'LUNAS' : 'BELUM LUNAS' }})
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Two-Column Detail Layout: Timeline (Left) & Shipment Details (Right) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left 2 Cols: Timeline History -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Riwayat Perjalanan Paket
                        </h2>
                        <span class="text-xs text-slate-400">Urut dari waktu terbaru</span>
                    </div>

                    <!-- Vertical Timeline Nodes -->
                    <div class="relative pl-6 sm:pl-8 space-y-8 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                        @forelse($shipment->trackingActivities as $index => $activity)
                            <div class="relative group">
                                <!-- Node Dot -->
                                <div class="absolute -left-[27px] sm:-left-[35px] top-1 w-5 h-5 rounded-full border-4 border-white shadow-md 
                                    {{ $index === 0 ? 'bg-red-600 ring-4 ring-red-100' : 'bg-slate-400' }}"></div>

                                <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200/70 hover:border-blue-500/30 transition-all">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1.5">
                                        <h3 class="text-sm sm:text-base font-bold text-slate-900">{{ $activity->title }}</h3>
                                        <span class="text-xs font-semibold text-slate-500 font-mono">
                                            {{ \Carbon\Carbon::parse($activity->happened_at)->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 leading-relaxed">{{ $activity->description }}</p>
                                    @if($activity->location)
                                        <div class="mt-2 flex items-center gap-1 text-[11px] font-semibold text-blue-600">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            Lokasi: {{ $activity->location }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="relative">
                                <div class="absolute -left-[27px] top-1 w-5 h-5 rounded-full border-4 border-white shadow-md bg-blue-600 ring-4 ring-blue-100"></div>
                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200">
                                    <h4 class="text-sm font-bold text-slate-900">Kiriman Didaftarkan di Gudang</h4>
                                    <p class="text-xs text-slate-500 mt-1">Paket telah diterima di sistem dan siap dimasukkan ke dalam manifest dispatch.</p>
                                    <span class="text-xs text-slate-400 font-mono mt-2 block">{{ $shipment->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Col: Sender & Receiver Details -->
                <div class="space-y-6">
                    <!-- Sender & Receiver Card -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-5">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900 pb-3 border-b border-slate-100">
                            Informasi Pihak Pengirim & Penerima
                        </h3>

                        <!-- Sender Block -->
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block">Pengirim:</span>
                            <div class="text-sm font-bold text-slate-900">{{ $shipment->sender_name }}</div>
                            <div class="text-xs text-slate-500">{{ $shipment->origin_city }}</div>
                        </div>

                        <!-- Divider Arrow -->
                        <div class="flex items-center justify-center text-slate-300">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </div>

                        <!-- Receiver Block -->
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block">Penerima:</span>
                            <div class="text-sm font-bold text-slate-900">{{ $shipment->receiver_name }}</div>
                            <div class="text-xs text-slate-500">{{ $shipment->destination_city }}</div>
                        </div>
                    </div>

                    <!-- Hub Dispatch Info Card -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-4">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900 pb-3 border-b border-slate-100">
                            Cabang Penanggung Jawab
                        </h3>

                        <div class="text-xs space-y-2">
                            <div>
                                <span class="text-slate-400 block">Kantor Cabang Asal:</span>
                                <strong class="text-slate-900">{{ $shipment->originBranch->name ?? 'Makassar Hub' }}</strong>
                                <p class="text-slate-500 text-[11px] mt-0.5">{{ $shipment->originBranch->address ?? 'Makassar' }}</p>
                            </div>
                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-slate-400 block">Bantuan Pelanggan:</span>
                                <strong class="text-red-600">0812-3456-7890</strong>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @elseif($trackingNumber)
            <!-- Not Found State -->
            <div class="bg-white rounded-3xl p-12 text-center max-w-2xl mx-auto shadow-sm border border-slate-200/80 space-y-4">
                <div class="w-16 h-16 rounded-3xl bg-red-50 text-red-600 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Resi Tidak Ditemukan</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Nomor resi <strong class="text-slate-800 font-mono">{{ $trackingNumber }}</strong> belum terdaftar dalam sistem. Pastikan nomor resi yang Anda masukkan sudah benar atau silakan coba beberapa resi contoh di bawah.
                </p>
                <div class="pt-2 flex flex-wrap justify-center gap-2 text-xs">
                    <a href="{{ route('track', ['resi' => 'UPG2610339']) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-red-50 hover:text-red-600 font-mono font-medium">UPG2610339</a>
                    <a href="{{ route('track', ['resi' => 'SUB2610036']) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-red-50 hover:text-red-600 font-mono font-medium">SUB2610036</a>
                </div>
            </div>
        @else
            <!-- Initial State (No query yet) -->
            <div class="bg-white rounded-3xl p-12 text-center max-w-xl mx-auto shadow-sm border border-slate-200/80 space-y-4">
                <div class="w-16 h-16 rounded-3xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Masukkan Nomor Resi Anda di Atas</h3>
                <p class="text-xs sm:text-sm text-slate-500">
                    Sistem pelacakan Andex Cargo diperbarui secara otomatis setiap kali paket berpindah pos atau armada.
                </p>
            </div>
        @endif

    </div>
</div>
@endsection
