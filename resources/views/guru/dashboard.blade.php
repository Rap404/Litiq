@extends('layouts.app')

@section('content')

    {{-- Main --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        <header class="bg-white border-b border-orange-200 h-14 flex items-center justify-between px-6 flex-shrink-0">
            <span class="text-[15px] font-semibold text-gray-800">Dashboard</span>
            <div class="flex items-center gap-2.5">
                <a href="#" class="w-[34px] h-[34px] rounded-lg border border-orange-200 bg-orange-50 flex items-center justify-center text-orange-700 hover:bg-orange-100 transition-colors">
                    <i class="ti ti-bell text-[16px]"></i>
                </a>
                <a href="#" class="w-[34px] h-[34px] rounded-lg border border-orange-200 bg-orange-50 flex items-center justify-center text-orange-700 hover:bg-orange-100 transition-colors">
                    <i class="ti ti-settings text-[16px]"></i>
                </a>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6 flex flex-col gap-4">

            {{-- Welcome Banner --}}
            <div class="bg-orange-500 rounded-xl px-6 py-5 flex items-center justify-between">
                <div>
                    <h2 class="text-[18px] font-semibold text-white mb-1">Selamat datang, {{ auth()->user()->name }}!</h2>
                    <p class="text-[13px] text-white/75">{{ now()->translatedFormat('l, d F Y') }} · {{ $activeQuizzes ?? 0 }} kuis aktif hari ini</p>
                </div>
                <i class="ti ti-book-2 text-[48px] text-white opacity-20"></i>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-3 gap-3.5">
                <div class="bg-white border border-orange-200 rounded-xl p-4">
                    <div class="w-9 h-9 rounded-lg bg-orange-100 text-orange-700 flex items-center justify-center text-lg mb-2">
                        <i class="ti ti-school"></i>
                    </div>
                    <div class="text-[12px] text-gray-500">Total Kelas</div>
                    <div class="text-[26px] font-bold text-gray-900 leading-tight mt-0.5">{{ $totalClasses }}</div>
                </div>
                <div class="bg-white border border-orange-200 rounded-xl p-4">
                    <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center text-lg mb-2">
                        <i class="ti ti-users"></i>
                    </div>
                    <div class="text-[12px] text-gray-500">Total Murid</div>
                    <div class="text-[26px] font-bold text-gray-900 leading-tight mt-0.5">{{ $totalStudents }}</div>
                </div>
                <div class="bg-white border border-orange-200 rounded-xl p-4">
                    <div class="w-9 h-9 rounded-lg bg-red-100 text-red-800 flex items-center justify-center text-lg mb-2">
                        <i class="ti ti-checklist"></i>
                    </div>
                    <div class="text-[12px] text-gray-500">Total Kuis</div>
                    <div class="text-[26px] font-bold text-gray-900 leading-tight mt-0.5">{{ $totalQuizzes }}</div>
                </div>
            </div>

            {{-- Bottom Grid --}}
            <div class="grid grid-cols-[1.1fr_1fr] gap-3.5">

                {{-- Leaderboard --}}
                <div class="bg-white border border-orange-200 rounded-xl overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3.5 border-b border-orange-100">
                        <h3 class="text-[14px] font-semibold text-gray-800">
                            <i class="ti ti-trophy text-[15px] text-orange-400 mr-1.5"></i>Top Siswa
                        </h3>
                        <a href="#" class="text-[12px] text-orange-500 hover:text-orange-700">Lihat semua</a>
                    </div>
                    @foreach($leaderboard as $index => $student)
                    <div class="flex items-center gap-2.5 px-4 py-2.5 border-b border-orange-50 last:border-0 text-[13px]">
                        <div class="w-[22px] h-[22px] rounded-full flex items-center justify-center text-[11px] font-semibold flex-shrink-0
                            {{ $index == 0 ? 'bg-amber-100 text-amber-800' : ($index == 1 ? 'bg-gray-100 text-gray-600' : ($index == 2 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-500')) }}">
                            {{ $index + 1 }}
                        </div>
                        <span class="flex-1 text-gray-800">{{ $student->name }}</span>
                        <span class="text-[11px] bg-orange-100 text-orange-700 rounded-full px-2 py-0.5">Lv {{ $student->level }}</span>
                        <span class="text-[12px] text-gray-500 min-w-[52px] text-right">{{ number_format($student->xp) }} XP</span>
                    </div>
                    @endforeach
                </div>

                {{-- Kelas --}}
                <div class="bg-white border border-orange-200 rounded-xl overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3.5 border-b border-orange-100">
                        <h3 class="text-[14px] font-semibold text-gray-800">
                            <i class="ti ti-book text-[15px] text-orange-400 mr-1.5"></i>Kelas Saya
                        </h3>
                        <a href="{{ route('classes.create') }}"
                           class="inline-flex items-center gap-1 bg-orange-500 text-white text-[12px] font-medium px-3 py-1 rounded-lg hover:bg-orange-600 transition-colors">
                            <i class="ti ti-plus"></i> Kelas
                        </a>
                    </div>
                    @foreach($classes as $class)
                    <a href="{{ route('classes.show', $class->id) }}"
                       class="flex items-center gap-3 px-4 py-2.5 border-b border-orange-50 last:border-0 hover:bg-orange-50 transition-colors no-underline">
                        <div class="w-2 h-2 rounded-full bg-orange-400 flex-shrink-0"></div>
                        <div class="flex-1">
                            <div class="text-[13px] font-semibold text-gray-800">{{ $class->class_name }}</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">{{ $class->class_code }}</div>
                        </div>
                        <span class="text-[11px] bg-orange-100 text-orange-700 rounded-full px-2 py-0.5 whitespace-nowrap">
                            {{ $class->students->count() }} siswa
                        </span>
                    </a>
                    @endforeach
                </div>

            </div>
        </main>
    </div>
@endsection
