<h1>Dashboard Guru</h1>

<p>Selamat datang {{ auth()->user()->name }}</p>

<a href="{{ route('classes.index') }}">
    Kelola Kelas
</a>
