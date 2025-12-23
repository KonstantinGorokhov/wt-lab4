@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Заголовок --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        @if($selectedUser)
            <h1 class="mb-0">
                Президенты пользователя {{ $selectedUser->username }}
            </h1>
        @else
            <h1 class="mb-0">Все президенты</h1>
        @endif
    </div>

    {{-- Чекбокс удалённых --}}
    @auth
        @if(
            auth()->user()->is_admin ||
            ($selectedUser && auth()->id() === $selectedUser->id)
        )
            <form method="GET" class="mb-3">
                @if($selectedUser)
                    <input type="hidden"
                           name="username"
                           value="{{ $selectedUser->username }}">
                @endif

                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="with_trashed"
                           value="1"
                           onchange="this.form.submit()"
                           {{ request('with_trashed') ? 'checked' : '' }}>
                    <label class="form-check-label">
                        Показать удалённые карточки
                    </label>
                </div>
            </form>
        @endif
    @endauth

    {{-- Карточки --}}
    <div class="row">
        @forelse($presidents as $president)
            <div class="col-md-3 mb-4">
                <div class="card h-100 {{ $president->trashed() ? 'border-danger' : '' }}">

                    @if($president->image_path)
                        <img src="{{ asset('storage/'.$president->image_path) }}"
                             class="card-img-top"
                             style="height: 280px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="text-muted small mb-1">
                            {{ $president->term_period_formatted }}
                        </div>

                        <h5 class="mb-1">{{ $president->name_ru }}</h5>

                        <p class="small text-muted mb-2">
                            Добавил: {{ $president->user->username ?? '—' }}
                        </p>

                        @if($president->trashed())
                            <span class="badge bg-danger mb-2">Удалена</span>
                        @endif

                        <p class="card-text text-muted small flex-grow-1">
                            {{ $president->short_description }}
                        </p>

                        <a href="{{ route('presidents.show', $president) }}"
                           class="btn btn-sm btn-primary w-100 mb-2">
                            Подробнее
                        </a>
                    </div>

                    {{-- Восстановление --}}
                    @auth
                        @if(
                            $president->trashed() &&
                            (
                                auth()->user()->is_admin ||
                                auth()->id() === $president->user_id
                            )
                        )
                            <div class="card-footer">
                                <form method="POST"
                                      action="{{ route('presidents.restore', $president->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm w-100">
                                        Восстановить
                                    </button>
                                </form>

                                @if(auth()->user()->is_admin)
                                    <form method="POST"
                                          action="{{ route('presidents.forceDelete', $president->id) }}"
                                          class="mt-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm w-100">
                                            Удалить навсегда
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    Президентов не найдено
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection
