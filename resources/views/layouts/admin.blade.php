<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/admin/assignedTasks.js'])
    @stack('scripts')
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.assigned_tasks.index') }}"><i class="bi bi-check-circle"></i> Порученные задания</a></li>
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="{{ route('chats.index') }}">--}}
{{--                        <i class="bi bi-chat-dots"></i> Чат поддержки--}}
{{--                        @if(Auth::user()->getUnreadMessageCount() > 0)--}}
{{--                            <span class="badge bg-primary">{{ Auth::user()->getUnreadMessageCount() }}</span>--}}
{{--                        @endif--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.messages.index') }}"><i class="bi bi-envelope"></i> Сообщения</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.questions.index') }}"><i class="bi bi-question-circle"></i> Решения</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('ratingDisplay') }}"><i class="bi bi-graph-up"></i> Рейтинг</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-toggle-custom" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear"></i> Настройки
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.mentors.index') }}"><i class="bi bi-person"></i> Наставники</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Пользователи</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.lessons.index') }}"><i class="bi bi-book"></i> АйНоу</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.tasks.index') }}"><i class="bi bi-list-task"></i> Задачи</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle dropdown-toggle-custom" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="container-fluid py-4">
    @include('notifications.notifications')
    @yield('content')
</main>
</body>
</html>
