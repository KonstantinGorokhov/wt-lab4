@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Пользователи</h1>

        {{-- Чекбокс удалённых — ТОЛЬКО админ --}}
        @auth
            @if(auth()->user()->is_admin)
                <form method="GET">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="with_trashed"
                               value="1"
                               onchange="this.form.submit()"
                               {{ request('with_trashed') ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Показать удалённых
                        </label>
                    </div>
                </form>
            @endif
        @endauth
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Президенты</th>

                    @auth
                        @if(auth()->user()->is_admin)
                            <th>Действия</th>
                            <th>Удалено карточек</th>
                        @endif
                    @endauth
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr @if($user->deleted_at) class="table-secondary" @endif>
                        <td>{{ $user->id }}</td>

                        <td>
                            {{ $user->name }}
                            @if($user->is_admin)
                                <span class="badge bg-dark ms-1">admin</span>
                            @endif
                        </td>

                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>

                        <td>
                            <a href="{{ route('presidents.index', ['username' => $user->username]) }}"
                               class="btn btn-outline-secondary btn-sm">
                                Посмотреть ({{ $user->presidents_count }})
                            </a>
                        </td>

                        {{-- ADMIN --}}
                        @auth
                            @if(auth()->user()->is_admin)
                                <td class="text-nowrap">
                                    @if(auth()->id() !== $user->id)

                                        @if($user->trashed())
                                            <form method="POST"
                                                  action="{{ route('users.restore', $user->id) }}"
                                                  class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-outline-success btn-sm">
                                                    Восстановить
                                                </button>
                                            </form>

                                            <form method="POST"
                                                  action="{{ route('users.forceDelete', $user->id) }}"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm">
                                                    Удалить навсегда
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST"
                                                  action="{{ route('users.destroy', $user->id) }}"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-warning btn-sm">
                                                    Удалить
                                                </button>
                                            </form>
                                        @endif

                                    @else
                                        <span class="text-muted">Это вы</span>
                                    @endif
                                </td>

                                <td>
                                    @if($user->deleted_presidents_count > 0)
                                        <a href="{{ route('presidents.index', [
                                                'username' => $user->username,
                                                'with_trashed' => 1
                                            ]) }}"
                                           class="btn btn-outline-danger btn-sm">
                                            {{ $user->deleted_presidents_count }}
                                        </a>
                                    @else
                                        0
                                    @endif
                                </td>
                            @endif
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Пользователи не найдены
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
