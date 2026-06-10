<h1>Daftar Kelas</h1>

<a href="{{ route('classes.create') }}">
    Tambah Kelas
</a>

<hr>

@foreach($classes as $class)

<div>
<h3>{{ $class->class_name }}</h3>

<p>Kode Kelas: {{ $class->class_code }}</p>

<a href="{{ route('classes.show', $class->id) }}">
    Lihat Detail
</a>

</div>

@endforeach
