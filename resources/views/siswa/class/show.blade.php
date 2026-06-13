@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">

    <h1 class="text-3xl font-bold">
        {{ $class->class_name }}
    </h1>

    <p class="text-gray-500 mt-2">
        Kode Kelas:
        {{ $class->class_code }}
    </p>

</div>

<div class="grid md:grid-cols-2 gap-4 mb-6">

    <div class="bg-white p-5 rounded-lg shadow">

        <h3 class="text-gray-500">
            Total Materi
        </h3>

        <p class="text-3xl font-bold">
            {{ $class->materials->count() }}
        </p>

    </div>

    <div class="bg-white p-5 rounded-lg shadow">

        <h3 class="text-gray-500">
            Total Kuis
        </h3>

        <p class="text-3xl font-bold">
            {{ $class->quizzes->count() }}
        </p>

    </div>

</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">

    <div class="flex justify-between mb-4">

        <h2 class="text-xl font-bold">
            📚 Materi
        </h2>

    </div>

    @forelse($class->materials as $material)

        <div class="border rounded-lg p-4 mb-3">

            <h3 class="font-bold">
                {{ $material->title }}
            </h3>

            <p class="text-gray-500">
                {{ Str::limit($material->content, 100) }}
            </p>

        </div>

    @empty

        <p>Belum ada materi.</p>

    @endforelse

</div>

<div class="bg-white rounded-lg shadow p-6">

    <h2 class="text-xl font-bold mb-4">
        📝 Kuis
    </h2>

    @forelse($class->quizzes as $quiz)

        <div
            class="border rounded-lg p-4 mb-3 flex justify-between items-center"
        >

            <div>

                <h3 class="font-bold">
                    {{ $quiz->title }}
                </h3>

                <p class="text-gray-500">
                    Reward:
                    {{ $quiz->xp_reward }}
                    XP
                </p>

            </div>

            <a
                href="{{ route('student.quiz.show', $quiz->id) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded"
            >

                Kerjakan

            </a>

        </div>

    @empty

        <p>Belum ada kuis.</p>

    @endforelse

</div>


@endsection
