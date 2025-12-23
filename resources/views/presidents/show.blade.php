@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="row align-items-start">
        {{-- Фото --}}
        <div class="col-md-6">
            <div class="president-image-box">
                <img
                    src="{{ asset('storage/' . $president->image_path) }}"
                    alt="{{ $president->name_ru }}"
                >
            </div>
        </div>

        {{-- Описание --}}
        <div class="col-md-6">
            <h1 class="mb-1">{{ $president->name_ru }}</h1>
            <div class="text-muted mb-2">{{ $president->name_en }}</div>

            <div class="fw-bold mb-3">
                {{ $president->term_period_formatted }}
            </div>

            <p>{{ $president->full_description }}</p>

            <p class="text-muted mt-4">
                <strong>Добавил:</strong> {{ $president->user->username }}
            </p>

            <div class="d-flex gap-2 mt-3">
                @can('update-president', $president)
                    <a href="{{ route('presidents.edit', $president) }}" class="btn btn-warning">
                        Редактировать
                    </a>
                @endcan

                @can('delete-president', $president)
                    <form method="POST" action="{{ route('presidents.destroy', $president) }}" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            Удалить
                        </button>
                    </form>
                @endcan

                <a href="{{ route('presidents.index') }}" class="btn btn-outline-secondary">
                    Назад
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
