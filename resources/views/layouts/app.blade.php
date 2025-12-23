<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Президенты Франции')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    />
</head>
<body>

<div class="container">
    <header class="border-bottom border-2 border-dark">
        <nav class="navbar bg-transparent">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('presidents.index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Логотип" width="140" height="140" class="d-inline-block align-text-top">
                    <span class="fw-bold fs-4">Президенты Франции</span>
                </a>
               
                <a href="{{ route('presidents.create') }}" class="btn btn-dark fs-4">
                    Добавить
                </a>
            </div>
        </nav>
    </header>
</div>

<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

<div class="container border-top border-2 border-dark">
    <footer class="bg-transparent py-3 mt-5">
        <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <p class="mb-2 mb-sm-0 text-center text-sm-start fw-medium">
                Выполнил: <span class="fw-bold">Горохов Константин Алексеевич</span>
            </p>
            <div class="d-flex gap-3 justify-content-center justify-content-sm-end">
                <a href="https://t.me/soycomounangelenelcielo" target="_blank" class="text-dark fs-4">
                    <i class="fab fa-telegram"></i>
                </a>
                <a href="https://github.com/KonstantinGorokhov" target="_blank" class="text-dark fs-4">
                    <i class="fab fa-github"></i>
                </a>
            </div>
        </div>
    </footer>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
