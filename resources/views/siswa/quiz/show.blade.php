@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#FFF7F0] flex items-center justify-center py-8 px-4">
<div class="w-full max-w-xl">

  {{-- Progress Bar --}}
  <div class="h-1.5 bg-[#FFD9B8] rounded-full mb-0 overflow-hidden">
    <div id="progressBar" class="h-full bg-[#FF8C38] rounded-full transition-all duration-500" style="width: 0%"></div>
  </div>

  {{-- Card --}}
  <div class="bg-white border border-[#FFD9B8] rounded-2xl overflow-hidden shadow-sm">

    {{-- Header --}}
    <div class="bg-[#1A0A00] px-5 py-3.5 flex items-center justify-between">
      <div class="text-xs text-white/40">
        Soal <span id="qNum" class="text-[#FF8C38] font-semibold">1</span>
        / {{ $quiz->questions->count() }}
      </div>
      <div id="timerPill" class="flex items-center gap-1.5 bg-[#FF8C38]/15 border border-[#FF8C38]/30 rounded-full px-3 py-1 text-[#FF8C38] text-sm font-semibold">
        <i class="ti ti-clock text-sm"></i>
        <span id="timerVal">20</span>s
      </div>
    </div>

    {{-- Question --}}
    <div class="px-6 pt-7 pb-4">
      <div class="text-[10px] text-[#C45C00] font-semibold uppercase tracking-widest mb-2">Pertanyaan</div>
      <div id="questionText" class="text-[17px] font-semibold text-gray-900 leading-snug mb-6"></div>

      {{-- Options --}}
      <div id="optionsGrid" class="grid grid-cols-2 gap-2.5 mb-4"></div>

    </div>

    {{-- Dot Nav --}}
    <div id="dotNav" class="flex gap-1.5 px-6 pb-3 flex-wrap"></div>
  </div>

  {{-- Result Screen (hidden initially) --}}
  <div id="resultScreen" class="hidden flex-col items-center gap-4 py-10">
    <div class="w-20 h-20 rounded-full bg-[#FFF0E0] border-[3px] border-[#FF8C38] flex items-center justify-center text-3xl font-bold text-[#FF8C38]" id="resultScore"></div>
    <div class="text-xl font-semibold text-gray-900" id="resultTitle"></div>
    <div class="text-sm text-gray-500" id="resultSub"></div>
    <div class="flex gap-3">
      <div class="bg-white border border-[#FFD9B8] rounded-xl px-5 py-3 text-center">
        <div class="text-2xl font-bold text-gray-900" id="statCorrect">0</div>
        <div class="text-xs text-gray-500 mt-0.5">Benar</div>
      </div>
      <div class="bg-white border border-[#FFD9B8] rounded-xl px-5 py-3 text-center">
        <div class="text-2xl font-bold text-gray-900" id="statWrong">0</div>
        <div class="text-xs text-gray-500 mt-0.5">Salah</div>
      </div>
      <div class="bg-white border border-[#FFD9B8] rounded-xl px-5 py-3 text-center">
        <div class="text-2xl font-bold text-gray-900" id="statXP">0</div>
        <div class="text-xs text-gray-500 mt-0.5">XP Didapat</div>
      </div>
    </div>

    {{-- Hidden form to submit --}}
    <form id="submitForm" action="{{ route('student.quiz.submit', $quiz->id) }}" method="POST">
      @csrf
      <div id="hiddenAnswers"></div>
      <button type="submit" class="bg-[#FF8C38] hover:bg-[#e87a2c] text-white font-semibold text-sm rounded-xl py-3 px-8 transition mt-2">
        Kumpulkan Jawaban
      </button>
    </form>
  </div>

</div>
</div>
@php
$questions = $quiz->questions->map(function ($q) {
    return [
        'id' => $q->id,
        'question' => $q->question,
        'opts' => [
            $q->option_a,
            $q->option_b,
            $q->option_c,
            $q->option_d,
        ],
    ];
})->values();
@endphp

<script>
const questions = @json($questions);

const KEYS = ['A','B','C','D'];
const TIME_PER_Q = 20;

let current = 0;
let selected = null;
let answers  = {};
let correctCount = 0;
let timer = null, timeLeft = TIME_PER_Q;

const $progress   = document.getElementById('progressBar');
const $qNum       = document.getElementById('qNum');
const $timerPill  = document.getElementById('timerPill');
const $timerVal   = document.getElementById('timerVal');
const $qText      = document.getElementById('questionText');
const $grid       = document.getElementById('optionsGrid');
const $dotNav     = document.getElementById('dotNav');
const $card       = document.querySelector('.bg-white');
const $result     = document.getElementById('resultScreen');
const $hiddenAns  = document.getElementById('hiddenAnswers');

function renderDots() {
  $dotNav.innerHTML = '';
  questions.forEach((_, i) => {
    const d = document.createElement('div');
    const base = 'w-2 h-2 rounded-full transition-colors duration-200 ';
    d.className = base + (i === current ? 'bg-[#1A0A00]' : answers[questions[i].id] ? 'bg-[#FF8C38]' : 'bg-[#FFD9B8]');
    $dotNav.appendChild(d);
  });
}

function startTimer() {
  clearInterval(timer);
  timeLeft = TIME_PER_Q;
  $timerVal.textContent = timeLeft;
  $timerPill.className = 'flex items-center gap-1.5 bg-[#FF8C38]/15 border border-[#FF8C38]/30 rounded-full px-3 py-1 text-[#FF8C38] text-sm font-semibold';
  timer = setInterval(() => {
    timeLeft--;
    $timerVal.textContent = timeLeft;
    if (timeLeft <= 5) {
      $timerPill.className = 'flex items-center gap-1.5 bg-red-50 border border-red-300 rounded-full px-3 py-1 text-red-500 text-sm font-semibold animate-pulse';
    }
    if (timeLeft <= 0) { clearInterval(timer); timeout(); }
  }, 1000);
}

function nextQuestion() {
  current++;

  if (current >= questions.length) {
    showResult();
  } else {
    loadQuestion();
  }
}

function timeout() {
  if (selected !== null) return;

  selected = -1;

  setTimeout(() => {
    nextQuestion();
  }, 300);
}

function loadQuestion() {
  const q = questions[current];
  selected = null;
  $qNum.textContent = current + 1;
  $progress.style.width = (current / questions.length * 100) + '%';
  $qText.textContent = q.question;
  $grid.innerHTML = '';

  q.opts.forEach((opt, i) => {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.innerHTML = `
      <div class="w-7 h-7 rounded-lg bg-[#FFF0E0] text-[#C45C00] text-xs font-bold flex items-center justify-center flex-shrink-0 transition-colors">${KEYS[i]}</div>
      <span class="text-sm text-gray-800 text-left leading-snug">${opt}</span>
    `;
    btn.className = 'flex items-center gap-2.5 bg-white border-[1.5px] border-[#FFD9B8] rounded-xl px-3.5 py-3 hover:border-[#FF8C38] hover:bg-[#FFF7F0] transition cursor-pointer w-full';
    btn.addEventListener('click', () => pick(i, btn, q));
    $grid.appendChild(btn);
  });

  renderDots();
  startTimer();
}

function pick(idx, btn, q) {
  if (selected !== null) return;

  clearInterval(timer);
  selected = idx;

  answers[q.id] = KEYS[idx];

  btn.classList.add('border-[#FF8C38]', 'bg-[#FFF0E0]');
  btn.querySelector('div').classList.add('!bg-[#FF8C38]', '!text-white');

  setTimeout(() => {
    nextQuestion();
  }, 300);
}

function showResult() {
  clearInterval(timer);
  $card.classList.add('hidden');
  $result.classList.remove('hidden');
  $result.classList.add('flex');
  $progress.style.width = '100%';

  const total = questions.length;
  const answered = Object.keys(answers).length;
  document.getElementById('statCorrect').textContent = '—';
  document.getElementById('statWrong').textContent   = '—';
  document.getElementById('statXP').textContent      = answered * 10 + ' XP';
  document.getElementById('resultScore').textContent = answered + '/' + total;
  document.getElementById('resultTitle').textContent = 'Kuis Selesai!';
  document.getElementById('resultSub').textContent   = answered + ' dari ' + total + ' soal dijawab.';

  // Inject hidden inputs
  $hiddenAns.innerHTML = '';
  Object.entries(answers).forEach(([id, val]) => {
    const inp = document.createElement('input');
    inp.type = 'hidden';
    inp.name = `answers[${id}]`;
    inp.value = val;
    $hiddenAns.appendChild(inp);
  });
}

loadQuestion();
</script>

@endsection
