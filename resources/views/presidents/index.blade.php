@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-3">Все президенты</h2>

    {{-- Фильтры --}}
    <form method="GET" class="mb-3 d-flex gap-3 align-items-center">
        @can('restore-president', App\Models\President::class)
            <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       name="with_trashed"
                       value="1"
                       id="withTrashed"
                       {{ request('with_trashed') ? 'checked' : '' }}>
                <label class="form-check-label" for="withTrashed">
                    Показать удалённые
                </label>
            </div>
        @endcan

        <button class="btn btn-outline-secondary btn-sm">
            Применить
        </button>
    </form>

    {{-- Сортировка --}}
    <a href="{{ route('presidents.index', [
            'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
        ]) }}"
       class="btn btn-outline-secondary btn-sm mb-4">
        Сортировать по дате начала
        {{ request('direction') === 'asc' ? '↑' : '↓' }}
    </a>

    {{-- Карточки --}}
    <div class="row g-4">
        @forelse($presidents as $president)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">

                    @if($president->image_path)
                        <img src="{{ asset('storage/' . $president->image_path) }}"
                             class="card-img-top"
                             alt="{{ $president->name_ru }}">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <p class="text-muted mb-1">
                            {{ $president->period }}
                        </p>

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
        @empty
            <p>Президенты не найдены.</p>
        @endforelse
    </div>

</div>
@endsection
