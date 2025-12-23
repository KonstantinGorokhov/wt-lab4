@extends('layouts.app')

@section('title', 'Президенты Франции')

@section('content')
<main>

    @php
        $nextDir = ($dir === 'asc') ? 'desc' : 'asc';
        $arrow = ($dir === 'asc') ? '↑' : '↓';
    @endphp

    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('presidents.index', ['direction' => $nextDir]) }}"
           class="btn btn-outline-dark btn-sm">
            Сортировать по дате начала {{ $arrow }}
        </a>
    </div>

    <div class="row g-4">

        @foreach($presidents as $president)
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-3">

                <div class="card shadow-sm border-0 rounded-4 h-100 position-relative overflow-hidden">

                    <div class="position-absolute top-0 start-0 m-2 px-2 py-1 bg-white rounded text-dark fw-semibold small shadow-sm">
                        {{ $president->period }}
                    </div>

                    @if($president->image_path)
                        <img src="{{ asset('storage/' . $president->image_path) }}"
                             class="card-img-top"
                             alt="{{ $president->name_en }}">
                    @endif

                    <div class="card-body bg-light-subtle d-flex flex-column">
                        <small class="text-muted">{{ $president->name_en }}</small>
                        <h5 class="card-title fw-bold mb-2">{{ $president->name_ru }}</h5>
                        <p class="card-text text-muted">{{ $president->short_description }}</p>

                        <div class="mt-auto d-flex justify-content-center">
                            <a href="{{ route('presidents.show', $president) }}" class="btn btn-outline-dark btn-sm">
                                Подробнее
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        @endforeach

    </div>

</main>
@endsection
