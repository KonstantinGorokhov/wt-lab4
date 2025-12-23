@extends('layouts.app')

@section('title', 'Президенты Франции')

@section('content')

<div class="mb-4">
    <form method="GET" action="{{ route('presidents.index') }}">
        <button type="submit"
                name="direction"
                value="{{ $dir === 'asc' ? 'desc' : 'asc' }}"
                class="btn btn-outline-secondary">
            Сортировать по дате начала {{ $dir === 'asc' ? '↑' : '↓' }}
        </button>
    </form>
</div>

<div class="row g-4">
    @foreach ($presidents as $president)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100">
                @if ($president->image_path)
                    <img src="{{ asset('storage/' . $president->image_path) }}"
                         class="card-img-top"
                         alt="{{ $president->name_ru }}">
                @endif

                <div class="card-body d-flex flex-column">
                    <small class="text-muted mb-1">
                        {{ $president->term_period_formatted }}
                    </small>

                    <div class="text-muted">
                        {{ $president->name_en }}
                    </div>

                    <h5 class="card-title">
                        {{ $president->name_ru }}
                    </h5>

                    <p class="card-text">
                        {{ $president->short_description }}
                    </p>

                    <a href="{{ route('presidents.show', $president) }}"
                       class="btn btn-outline-primary mt-auto">
                        Подробнее
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
