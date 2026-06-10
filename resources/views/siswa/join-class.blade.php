<h1>Join Kelas</h1>

<form action="{{ route('join.class.store') }}"
      method="POST">

    @csrf

    <input
        type="text"
        name="class_code"
        placeholder="Masukkan kode kelas"
    >

    <button type="submit">
        Gabung
    </button>

</form>
