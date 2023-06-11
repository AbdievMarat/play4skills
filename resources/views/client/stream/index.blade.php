@extends('layouts.client')

@section('content')
    <div class="container-fluid row px-2 py-4">
        <div class="col-md-4">
            <div class="card mb-3">
                <img src="{{ asset('box.png') }}" class="mx-auto" style="max-width: 370px" alt="">
                <div class="card-body">
                    <h5 class="card-title">Задай вопрос</h5>
                    <p class="card-text">Для получения ключа необходимо выполнить задание</p>

                    <form class="input-group @error('question_content') is-invalid @enderror" method="POST" action="{{ route('storeQuestion') }}">
                        @csrf

                        <span class="input-group-text">{{ $amountKeys }}</span>
                        <span class="input-group-text"><i class="bi bi-key-fill"></i></span>

                        <input type="text" name="question_content" class="form-control @error('question_content') is-invalid @enderror" value="{{ old('question_content') }}" placeholder="Введите вопрос" aria-label="Введите вопрос" aria-describedby="submit-question">

                        <button type="submit" class="btn btn-primary" id="submit-question" @if($amountKeys === 0) disabled @endif>Отправить</button>
                    </form>

                    @error('question_content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Отправленные вопросы
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($questions as $question)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-9">{{ $question->content }}</div>
                                <div class="col-3"><small class="text-muted">{{ $question->status }}</small></div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">Нет оправленных вопросов</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div style="position: relative; height: 600px; overflow: auto;">
                @foreach($messages as $message)
                    <div class="d-flex flex-row justify-content-start">
                        <img src="{{ asset('avatar-default.webp') }}" alt="avatar" style="width: 45px; height: 100%;">
                        <div>
                            <div
                                class="small p-2 ms-3 mb-1 rounded-3 bg-secondary bg-opacity-25">{!! $message->content !!}</div>
                            <p class="small ms-3 mb-3 rounded-3 text-muted float-end">{{ date_format(date_create($message->created_at), 'd.m.Y H:i') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <form
                class="text-muted d-flex justify-content-start align-items-center pt-3 mt-2 @error('content') is-invalid @enderror"
                method="POST" action="{{ route('storeMessage') }}">
                @csrf
                <img
                    src="{{ asset('avatar-default.webp') }}"
                    alt="avatar 3" style="width: 40px; height: 100%;">

                <input type="text" name="content"
                       class="form-control form-control-lg ms-3 @error('content') is-invalid @enderror"
                       placeholder="Введите сообщение" value="{{ old('content') }}">

                <button type="submit" class="btn"><i class="bi bi-send" title="Отправить"></i></button>
            </form>

            @error('content')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
@endsection
