<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Bootstrap / App styles --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

{{-- ================= HEADER ================= --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">

        {{-- Logo / Title --}}
        <a class="navbar-brand fw-bold" href="{{ route('presidents.index') }}">
            Президенты Франции
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            {{-- Left side --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">

                <li class="nav-item">
                    <a href="{{ route('presidents.create') }}"
                       class="btn btn-outline-primary btn-sm">
                        Добавить президента
                    </a>
                </li>

                @can('manage-users')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                           class="btn btn-outline-dark btn-sm">
                            Пользователи
                        </a>
                    </li>
                @endcan

            </ul>

            {{-- Right side --}}
            <ul class="navbar-nav ms-auto align-items-center gap-3">

                <li class="nav-item text-muted">
                    {{ auth()->user()->name }}
                    @if(auth()->user()->is_admin)
                        <span class="badge bg-dark ms-1">admin</span>
                    @endif
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm">
                            Выйти
                        </button>
                    </form>
                </li>

            </ul>

        </div>
    </div>
</nav>

{{-- ================= CONTENT ================= --}}
<main class="flex-grow-1 py-4">
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
<footer class="bg-white border-top py-3 mt-auto">
    <div class="container d-flex justify-content-between text-muted small">
        <div>
            Выполнил: <strong>Константин Горохов</strong>
        </div>
        <div>
            Лабораторная работа №4 · Laravel
        </div>
    </div>
</footer>

{{-- Scripts --}}
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
