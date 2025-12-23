<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Президенты Франции')</title>

    {{-- Bootstrap (основной контент) --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    {{-- Tailwind (header + footer) --}}
    <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          crossorigin="anonymous" />
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <div class="flex items-center gap-8">
                <a href="{{ route('presidents.index') }}"
                   class="text-xl font-semibold text-gray-800 hover:text-blue-600">
                    Президенты Франции
                </a>

                @auth
                <nav class="flex items-center gap-4 text-gray-600 ml-3">
                    <a href="{{ route('presidents.create') }}" class="hover:text-blue-600">
                        Добавить президента
                    </a>

                    @if (Route::has('users.index'))
                        <a href="{{ route('users.index') }}" class="hover:text-blue-600">
                            Пользователи
                        </a>
                    @endif
                </nav>

                @endauth
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm text-gray-600">
                        {{ Auth::user()->name }}
                    </span>

                    @if (Route::has('admin.dashboard'))
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-3 py-1 text-sm border rounded hover:bg-gray-100">
                            Админка
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1 text-sm border rounded hover:bg-gray-100">
                            Выйти
                        </button>
                    </form>
                @endauth
            </div>

        </div>
    </header>


<main class="flex-grow py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="bg-white border-t">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between text-sm text-gray-600">

        <div>
            Выполнил: <strong>Горохов Константин Алексеевич</strong>
        </div>

        <div class="flex items-center gap-4 text-lg">
            <a href="https://github.com/KonstantinGorokhov"
               target="_blank"
               class="hover:text-black">
                <i class="fab fa-github"></i>
            </a>

            <a href="https://t.me/"
               target="_blank"
               class="hover:text-blue-500">
                <i class="fab fa-telegram"></i>
            </a>
        </div>

    </div>
</footer>

</body>
</html>
