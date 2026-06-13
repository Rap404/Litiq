 {{-- Sidebar --}}
    <aside class="w-56 min-h-screen bg-[#1A0A00] flex flex-col flex-shrink-0">
        <div class="px-5 py-5 border-b border-white/10">
            <div class="text-xl font-semibold text-orange-400 tracking-tight">LITIQ</div>
            <div class="text-[11px] text-white/30 mt-0.5">Learning Through Interactive Quiz</div>
        </div>

        <nav class="flex-1 px-2.5 py-3">
            <div class="text-[10px] text-white/30 uppercase tracking-widest px-2.5 py-2">Menu</div>

            <a href="/dashboard"
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[13px] mb-0.5 bg-orange-500 text-white">
                <i class="ti ti-layout-dashboard text-[17px]"></i> Dashboard
            </a>
            <a href="/classes"
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[13px] mb-0.5 text-white/50 hover:bg-white/5 hover:text-white/80 transition-colors">
                <i class="ti ti-school text-[17px]"></i> Kelas Saya
            </a>
            <a href=""
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[13px] mb-0.5 text-white/50 hover:bg-white/5 hover:text-white/80 transition-colors">
                <i class="ti ti-checklist text-[17px]"></i> Kuis
            </a>
            <a href="#"
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[13px] mb-0.5 text-white/50 hover:bg-white/5 hover:text-white/80 transition-colors">
                <i class="ti ti-users text-[17px]"></i> Siswa
            </a>

            <div class="text-[10px] text-white/30 uppercase tracking-widest px-2.5 py-2 mt-2">Laporan</div>
            <a href="#"
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[13px] mb-0.5 text-white/50 hover:bg-white/5 hover:text-white/80 transition-colors">
                <i class="ti ti-chart-bar text-[17px]"></i> Hasil Kuis
            </a>
            <a href="#"
               class="flex items-center gap-2.5 px-2.5 py-2 rounded-lg text-[13px] mb-0.5 text-white/50 hover:bg-white/5 hover:text-white/80 transition-colors">
                <i class="ti ti-trophy text-[17px]"></i> Leaderboard
            </a>
        </nav>

        <div class="px-2.5 py-3.5 border-t border-white/10">
            <div class="flex items-center gap-2 px-2.5 py-2 rounded-lg">
                <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-[12px] font-semibold text-white flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <div class="text-[12px] font-semibold text-white/70">{{ auth()->user()->name }}</div>
                    <div class="text-[11px] text-white/30">Guru</div>
                </div>
            </div>
        </div>
    </aside>
