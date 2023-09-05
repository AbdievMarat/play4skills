@extends('layouts.client')

@section('content')
    <div id="rating-detail-container"></div>
    <div class="container">
        <div class="alert alert-primary d-flex align-items-center mt-4" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            <div>
                Совсем скоро вы узнаете имена победителей, а пока мы реши скрыть рейтинг для поддержания интриги.
            </div>
        </div>
{{--        @foreach($rating_users as $rating_user)--}}
{{--            <nav class="navbar mt-4 btn btn-outline-success detail" data-user_id="{{ $rating_user['id'] }}">--}}
{{--                <a class="navbar-brand" href="#">--}}
{{--                    <img--}}
{{--                        src="{{ $rating_user['avatar'] ? asset('storage/'.$rating_user['avatar']) : asset('avatar-default.webp') }}"--}}
{{--                        alt="avatar" class="d-inline-block mx-3"--}}
{{--                        width="60">--}}
{{--                    {{ $rating_user['name'] }}--}}
{{--                </a>--}}
{{--                <button class="btn btn-danger me-2" type="button">{{ $rating_user['total_points'] ?? 0 }}</button>--}}
{{--            </nav>--}}
{{--            <div class="progress">--}}
{{--                <div class="progress-bar" role="progressbar" style="width: {{ $rating_user['percentage'] }}%"--}}
{{--                     aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
    </div>
@endsection
