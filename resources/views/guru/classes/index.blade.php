@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold">
            📚 Kelas Saya
        </h1>

        <p class="text-gray-500">
            Kelola kelas dan aktivitas belajar siswa
        </p>

    </div>

    <a
        href="{{ route('classes.create') }}"
        class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700"
    >
        + Buat Kelas
    </a>

</div>

<div class="grid md:grid-cols-3 gap-4 mb-6">

    <div class="bg-white rounded-lg shadow p-5">

        <p class="text-gray-500">
            Total Kelas
        </p>

        <h2 class="text-3xl font-bold">
            {{ $classes->count() }}
        </h2>

    </div>

    <div class="bg-white rounded-lg shadow p-5">

        <p class="text-gray-500">
            Total Materi
        </p>

        <h2 class="text-3xl font-bold">
            {{ $classes->sum(fn($class) => $class->materials->count()) }}
        </h2>

    </div>

    <div class="bg-white rounded-lg shadow p-5">

        <p class="text-gray-500">
            Total Kuis
        </p>

        <h2 class="text-3xl font-bold">
            {{ $classes->sum(fn($class) => $class->quizzes->count()) }}
        </h2>

    </div>

</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach($classes as $class)

        <div class="bg-white rounded-lg shadow p-5">

            <h2 class="text-xl font-bold">
                {{ $class->class_name }}
            </h2>

            <p class="text-gray-500 mt-2">
                Kode:
                {{ $class->class_code }}
            </p>

            <div class="mt-4">
                <a
                    href="{{ route('classes.show', $class->id) }}"
                    class="inline-block bg-blue-600 text-white px-4 py-2 rounded"
                >
                    Buka Kelas
                </a>


</div>

        </div>


    @endforeach

</div>

@endsection
