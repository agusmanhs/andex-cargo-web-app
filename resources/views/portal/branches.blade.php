@extends('layouts.portal')

@section('title', 'Jaringan Kantor Cabang & Gudang Hub - Andex Cargo')

@section('content')
<div class="bg-slate-100/70 min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold uppercase tracking-wider">
                Jangkauan Nasional
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Jaringan Kantor Cabang & Hub Kargo
            </h1>
            <p class="text-sm text-slate-500 leading-relaxed">
                Temukan lokasi drop point, gudang transit, dan kantor perwakilan Andex Cargo terdekat di kota Anda.
            </p>
        </div>

        <!-- 20 Branches Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($branches as $branch)
                <div class="card-elevated bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:border-blue-500/40 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-xl font-mono font-bold text-xs {{ $branch->type === 'HUB' ? 'bg-red-50 text-red-700 border border-red-200/60' : 'bg-slate-100 text-slate-700' }}">
                                {{ $branch->code }}
                            </span>
                            <span class="text-[11px] font-bold uppercase tracking-wider {{ $branch->type === 'HUB' ? 'text-red-600 font-extrabold' : 'text-slate-400' }}">
                                {{ $branch->type === 'HUB' ? '★ Gudang Hub Utama' : 'Kantor Cabang' }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $branch->name }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed mb-4">
                            {{ $branch->address ?: 'Alamat kantor cabang resmi Andex Cargo.' }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400">Operasional: <strong>Senin - Sabtu</strong></span>
                        <a href="https://wa.me/6281234567890?text=Halo%20Andex%20Cargo%20Cabang%20{{ urlencode($branch->name) }}" target="_blank" class="text-red-600 font-bold hover:text-red-700 flex items-center gap-1">
                            Hubungi Cabang &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
