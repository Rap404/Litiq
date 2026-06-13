@extends('layouts.app')

@section('content')

@php
    $rank = $leaderboard->search(fn($item) => $item->id == $user->id) + 1;
@endphp
  <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Topbar --}}
        <div class="bg-white border-b border-[#FFD9B8] px-6 h-14 flex items-center justify-between flex-shrink-0">
            <span class="text-[15px] font-semibold text-gray-900">Dashboard</span>
            <div class="flex items-center gap-2.5">
                <a href="#" class="w-[34px] h-[34px] rounded-lg border border-[#FFD9B8] bg-[#FFF7F0] flex items-center justify-center text-[#C45C00] text-base hover:bg-[#FFE8CC] transition">
                    <i class="ti ti-bell"></i>
                </a>
                <a href="#" class="w-[34px] h-[34px] rounded-lg border border-[#FFD9B8] bg-[#FFF7F0] flex items-center justify-center text-[#C45C00] text-base hover:bg-[#FFE8CC] transition">
                    <i class="ti ti-settings"></i>
                </a>
            </div>
        </div>

        <div class="p-6 overflow-y-auto flex-1 flex flex-col gap-4">

            {{-- Hero Card --}}
            <div class="bg-[#1A0A00] rounded-xl px-6 py-5 flex items-center gap-5 flex-wrap">
                <div class="w-14 h-14 rounded-full bg-[#FF8C38] flex items-center justify-center text-xl font-bold text-white flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <div class="text-lg font-semibold text-white mb-0.5">Halooo, {{ $user->name }}!</div>
                    <div class="text-xs text-white/45 mb-2.5">Terus semangat belajarnya hari ini</div>
                    <div class="flex items-center gap-2.5">
                        <div class="flex-1 h-1.5 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-[#FF8C38] rounded-full" style="width: {{ $progressPercent }}%;"></div>
                        </div>
                        <span class="text-[11px] text-white/40 whitespace-nowrap">{{ number_format($user->xp) }} / {{ number_format($nextLevelXp ?? 1000) }} XP</span>
                    </div>
                </div>
                <div class="flex-shrink-0 text-right">
                    <div class="bg-[#FF8C38] text-white text-xs font-semibold px-3 py-1 rounded-full inline-block">#{{ $rank }}</div>
                    <div class="text-[11px] text-white/35 text-right mt-1">Ranking kelas</div>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="bg-white border border-[#FFD9B8] rounded-xl px-4 py-3.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-base mb-2 bg-[#FFF0E0] text-[#C45C00]">
                        <i class="ti ti-flame"></i>
                    </div>
                    <div class="text-[11px] text-gray-500">Level</div>
                    <div class="text-2xl font-bold text-gray-900 leading-tight mt-0.5">{{ $user->level }}</div>
                </div>
                <div class="bg-white border border-[#FFD9B8] rounded-xl px-4 py-3.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-base mb-2 bg-[#FEF3CD] text-[#854F0B]">
                        <i class="ti ti-star"></i>
                    </div>
                    <div class="text-[11px] text-gray-500">Total XP</div>
                    <div class="text-2xl font-bold text-gray-900 leading-tight mt-0.5">{{ number_format($user->xp) }}</div>
                </div>
                <div class="bg-white border border-[#FFD9B8] rounded-xl px-4 py-3.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-base mb-2 bg-[#FAECE7] text-[#993C1D]">
                        <i class="ti ti-medal"></i>
                    </div>
                    <div class="text-[11px] text-gray-500">Badge</div>
                    <div class="text-2xl font-bold text-gray-900 leading-tight mt-0.5">{{ $user->badges->count() }}</div>
                </div>
            </div>

            {{-- Bottom Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-[1.1fr_1fr] gap-3.5">

                {{-- Leaderboard --}}
                <div class="bg-white border border-[#FFD9B8] rounded-xl overflow-hidden">
                    <div class="px-[18px] py-3.5 border-b border-[#FFD9B8] flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                            <i class="ti ti-trophy text-[15px] text-[#FF8C38] mr-1.5"></i>Leaderboard
                        </h3>
                        <a href="#" class="text-xs text-[#FF8C38]">Lihat semua</a>
                    </div>
                    @foreach($leaderboard as $index => $student)
                    <div class="flex items-center gap-2.5 px-[18px] py-2.5 border-b border-[#FFF0E0] last:border-b-0 text-sm {{ $student->id == $user->id ? 'bg-[#FFF7F0]' : '' }}">
                        <div class="w-[22px] h-[22px] rounded-full flex items-center justify-center text-[11px] font-semibold flex-shrink-0
                            {{ $index == 0 ? 'bg-[#FEF3CD] text-[#854F0B]' : ($index == 1 ? 'bg-[#F0F0F0] text-[#444]' : ($index == 2 ? 'bg-[#FAECE7] text-[#993C1D]' : 'bg-[#F5F5F5] text-[#888]')) }}">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 text-gray-900">
                            {{ $student->name }}
                            @if($student->id == $user->id)
                                <span class="text-[10px] bg-[#FFF0E0] text-[#C45C00] px-1.5 py-px rounded-full ml-1">kamu</span>
                            @endif
                        </div>
                        <div class="text-[11px] bg-[#FFF0E0] text-[#C45C00] rounded-full px-2 py-0.5">Lv {{ $student->level }}</div>
                        <div class="text-xs text-gray-500 min-w-[52px] text-right">{{ number_format($student->xp) }} XP</div>
                    </div>
                    @endforeach
                </div>

                {{-- Badge + Kelas --}}
                <div class="flex flex-col gap-3.5">

                    {{-- Badge --}}
                    <div class="bg-white border border-[#FFD9B8] rounded-xl overflow-hidden">
                        <div class="px-[18px] py-3.5 border-b border-[#FFD9B8] flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                                <i class="ti ti-medal text-[15px] text-[#FF8C38] mr-1.5"></i>Badge saya
                            </h3>
                            <a href="#" class="text-xs text-[#FF8C38]">Semua</a>
                        </div>
                        @if($user->badges->count())
                            <div class="grid grid-cols-2 gap-2 p-3.5">
                                @foreach($user->badges->take(4) as $badge)
                                <div class="border border-[#FFD9B8] rounded-lg p-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-[#FFF0E0] flex items-center justify-center text-sm text-[#C45C00] mb-1.5">
                                        <i class="ti ti-award"></i>
                                    </div>
                                    <div class="text-xs font-semibold text-gray-900">{{ $badge->name }}</div>
                                    <div class="text-[11px] text-gray-500 mt-px">{{ $badge->description }}</div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="px-[18px] py-4 text-sm text-gray-500">Belum ada badge. Kerjakan kuis untuk mendapatkan badge pertamamu!</div>
                        @endif
                    </div>

                    {{-- Kelas --}}
                    <div class="bg-white border border-[#FFD9B8] rounded-xl overflow-hidden">
                        <div class="px-[18px] py-3.5 border-b border-[#FFD9B8] flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                                <i class="ti ti-book text-[15px] text-[#FF8C38] mr-1.5"></i>Kelas saya
                            </h3>
                        </div>
                        @foreach($classes as $class)
                        <a href="{{ route('student.classes.show', $class->id) }}" class="flex items-center gap-3 px-[18px] py-2.75 border-b border-[#FFF0E0] last:border-b-0 hover:bg-[#FFF7F0] transition">
                            <div class="w-2 h-2 rounded-full bg-[#FF8C38] flex-shrink-0"></div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-gray-900">{{ $class->class_name }}</div>
                                <div class="text-[11px] text-gray-500 mt-px">
                                    {{ $class->materials->count() }} materi · {{ $class->quizzes->count() }} kuis
                                </div>
                            </div>
                            <i class="ti ti-chevron-right text-sm text-[#FFD9B8]"></i>
                        </a>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
