<h1>{{ $class->class_name }}</h1>

<p>Kode Kelas: {{ $class->class_code }}</p>

<hr>

<h2>Menu Kelas</h2>

<ul>

    <li>Materi</li>

    <li>Kuis</li>

    <li>Murid</li>

    <li>Leaderboard</li>

</ul>

<hr>

<h2>Tambah Materi</h2>

<form
    action="{{ route('materials.store', $class->id) }}"
    method="POST"
>

    @csrf

    <input
        type="text"
        name="title"
        placeholder="Judul Materi"
    >

    <br><br>

    <textarea
        name="content"
        rows="5"
        cols="50"
        placeholder="Isi Materi"
    ></textarea>

    <br><br>

    <button type="submit">
        Simpan Materi
    </button>

</form>

<hr>

<h2>Daftar Materi</h2>

@forelse($class->materials as $material)

    <div>

        <h3>{{ $material->title }}</h3>

        <p>{{ $material->content }}</p>

    </div>

    <hr>

@empty

    <p>Belum ada materi.</p>

@endforelse
