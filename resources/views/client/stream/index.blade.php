@extends('layouts.client')

@section('content')
    <div class="container-fluid row px-2 py-4">
        <div class="col-md-4">
            <div class="card mb-3">
                <img src="{{ asset('logo.png') }}" class="mx-auto" style="max-width: 100%" alt="">
                <div class="card-body">
                    <h5 class="card-title">{{ $configQuestion }}</h5>
                    <p class="card-text">{{ $configQuestionDescription }}</p>

                    <form class="input-group @error('question_content') is-invalid @enderror" method="POST" action="{{ route('storeQuestion') }}">
                        @csrf

                        <span class="input-group-text" style="font-size: 20px;">{{ $amountKeys }}</span>
                        <span class="input-group-text" style="font-size: 22px;"><i class="bi bi-lightbulb"></i></span>

                        <textarea name="question_content" rows="3" class="form-control @error('question_content') is-invalid @enderror" placeholder="Введите решение" aria-label="Введите решение" aria-describedby="submit-question">{{ old('question_content') }}</textarea>

                        <button type="submit" class="btn @if($amountKeys === 0) btn-secondary @else btn-primary @endif" id="submit-question" @if($amountKeys === 0) disabled @endif>Отправить</button>
                    </form>

                    @error('question_content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    Отправленные решения
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
                        <li class="list-group-item">Нет оправленных решений</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div style="position: relative; height: 600px; overflow: auto;">
                @foreach($messages as $message)
                    <div class="d-flex flex-row justify-content-start">
                        <div style="display: flex; flex-direction: column; width: 50px; font-size: 13px;">
                            <img src="{{ asset('avatar-default.webp') }}" alt="avatar" style="width: 45px;">
                            <span style="word-break: break-all;">{{ $message->user->name ?? '' }}</span>
                        </div>
                        <div>
                            <div
                                class="small p-2 ms-3 mb-1 rounded-3 bg-secondary bg-opacity-25">{!! $message->content !!}</div>
                            <p class="small ms-3 mb-3 rounded-3 text-muted float-end">{{ date('d.m.Y H:i', strtotime($message->created_at)) }}</p>
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
