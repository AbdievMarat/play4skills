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
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body>
<main>
<div id="rating-detail-container"></div>
<div class="container">
    @foreach($rating_users as $rating_user)
        <nav class="navbar mt-4 btn btn-outline-success detail" data-user_id="{{ $rating_user['id'] }}">
            <a class="navbar-brand" href="#">
                <img
                    src="{{ $rating_user['avatar'] ? asset('storage/'.$rating_user['avatar']) : asset('avatar-default.webp') }}"
                    alt="avatar" class="d-inline-block mx-3"
                    width="60">
                {{ $rating_user['name'] }}
            </a>
            <button class="btn btn-danger me-2" type="button">{{ $rating_user['total_points'] ?? 0 }}</button>
        </nav>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ $rating_user['percentage'] }}%"
                 aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    @endforeach
</div>
</main>
</body>
</html>
