@extends('layouts.app')

@section('title', $president->name_ru)

@section('content')
    <div class="row">

        <div class="col-md-5">
            @if($president->image_path)
                <img src="{{ asset('storage/' . $president->image_path) }}"
                     class="img-fluid rounded-4 shadow-sm"
                     alt="{{ $president->name_en }}">
            @endif
        </div>

        <div class="col-md-7">
            <h1 class="fw-bold mb-3">{{ $president->name_ru }}</h1>
            <p class="text-muted mb-1">{{ $president->name_en }}</p>
            <p class="fw-semibold">{{ $president->period }}</p>

            @if($president->term_start || $president->term_end)
                <p class="mt-2 mb-3">Срок: {{ $president->term_period_formatted }}</p>
            @endif

            <p class="fs-5">{{ $president->full_description ?? $president->short_description }}</p>


            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('presidents.edit', $president) }}" class="btn btn-warning">
                    Редактировать
                </a>

                <form action="{{ route('presidents.destroy', $president) }}" method="POST"
                      onsubmit="return confirm('Удалить этого президента?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">
                        Удалить
                    </button>
                </form>
            </div>

            <a href="{{ route('presidents.index') }}" class="btn btn-outline-secondary mt-3">
                Назад
            </a>

        </div>

    </div>
@endsection
