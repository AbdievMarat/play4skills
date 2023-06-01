@extends('layouts.client')

@section('content')
    @foreach($lessons as $lesson)
        <div class="card my-3 mx-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <div class="ratio ratio-16x9" style="max-height: 0; padding-bottom: 56.25%;">
                        <iframe src="{{ $lesson->link }}" allowfullscreen style="width: 100%; height: 100%;"></iframe>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $lesson->name }}</h5>
                        <p class="card-text">{!! $lesson->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
