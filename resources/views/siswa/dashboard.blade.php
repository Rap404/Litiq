<h1>Dashboard Murid</h1>

<p>Selamat datang {{ auth()->user()->name }}</p>

<a href="{{ route('join.class') }}">
    Join Kelas
</a>
