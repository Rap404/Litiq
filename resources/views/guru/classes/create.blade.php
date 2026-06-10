<form action="{{ route('classes.store') }}" method="POST">
    @csrf

    <input
        type="text"
        name="class_name"
        placeholder="Nama Kelas"
    >

    <button type="submit">
        Buat Kelas
    </button>
</form>
