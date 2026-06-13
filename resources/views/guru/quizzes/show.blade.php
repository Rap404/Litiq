<h1>{{ $quiz->title }}</h1>

<hr>

<h2>Tambah Soal</h2>

<form
    action="{{ route('questions.store', $quiz->id) }}"
    method="POST"
>

@csrf

<textarea
    name="question"
    placeholder="Pertanyaan"
></textarea>

<br><br>

<input name="option_a" placeholder="Opsi A">
<br><br>

<input name="option_b" placeholder="Opsi B">
<br><br>

<input name="option_c" placeholder="Opsi C">
<br><br>

<input name="option_d" placeholder="Opsi D">
<br><br>

<select name="correct_answer">

    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>

</select>

<br><br>

<button type="submit">
    Simpan Soal
</button>

</form>

<hr>

<h2>Daftar Soal</h2>

@foreach($quiz->questions as $question)

<div>

<p>
{{ $question->question }}
</p>

<ul>

<li>A. {{ $question->option_a }}</li>

<li>B. {{ $question->option_b }}</li>

<li>C. {{ $question->option_c }}</li>

<li>D. {{ $question->option_d }}</li>

</ul>

<p>
Jawaban: {{ $question->correct_answer }}
</p>

</div>

<hr>

@endforeach
