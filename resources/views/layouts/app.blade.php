<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

{{-- ================= HEADER ================= --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-3">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand fw-bold" href="{{ route('presidents.index') }}">
            Президенты Франции
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            {{-- Left --}}
            <ul class="navbar-nav me-auto gap-2">

                <li class="nav-item">
                    <a href="{{ route('presidents.index') }}"
                       class="btn btn-outline-primary btn-sm">
                        Все президенты
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a href="{{ route('presidents.create') }}"
                           class="btn btn-outline-primary btn-sm">
                            Добавить президента
                        </a>
                    </li>
                @endauth

                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                       class="btn btn-outline-secondary btn-sm">
                        Пользователи
                    </a>
                </li>

            </ul>

            {{-- Right --}}
            <ul class="navbar-nav ms-auto align-items-center gap-3">

                @auth
                    <li class="nav-item text-muted">
                        {{ auth()->user()->name }}
                        @if(auth()->user()->is_admin)
                            <span class="badge bg-dark ms-1">admin</span>
                        @endif
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">
                                Выйти
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}"
                           class="btn btn-outline-secondary btn-sm">
                            Войти
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('register') }}"
                           class="btn btn-primary btn-sm">
                            Регистрация
                        </a>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>

{{-- ================= CONTENT ================= --}}
<main class="flex-grow-1 py-4">
    @yield('content')
</main>

{{-- ================= FOOTER ================= --}}
<footer class="border-top mt-auto py-3 bg-white">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="text-muted">
            Выполнил: Константин Горохов
        </div>

        <div class="d-flex gap-3">
            <a href="https://github.com/ТВОЙ_GITHUB" target="_blank" class="text-dark">
                <i class="bi bi-github fs-4"></i>
            </a>
            <a href="https://t.me/ТВОЙ_TELEGRAM" target="_blank" class="text-dark">
                <i class="bi bi-telegram fs-4"></i>
            </a>
        </div>
    </div>
</footer>

{{-- Scripts --}}
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
