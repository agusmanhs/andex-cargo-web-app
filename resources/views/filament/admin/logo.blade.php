<div class="flex items-center gap-3 py-1">
    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center p-1.5 shadow-md overflow-hidden flex-shrink-0 border border-slate-200/50 fi-logo-circle">
        <img src="{{ asset('images/logo-icon.png') }}" alt="Andex Cargo" class="w-full h-full object-contain">
    </div>
    <div class="flex flex-col text-left">
        <span class="font-black text-[16px] tracking-tight leading-snug fi-logo-title text-white">Andex Cargo</span>
        <span class="text-[11px] font-semibold leading-tight fi-logo-subtitle text-blue-200">
            {{ auth()->check() ? (auth()->user()->role === 'SUPERADMIN' ? 'Head Office Admin' : 'Branch Manager') : 'Branch Manager' }}
        </span>
    </div>
</div>
