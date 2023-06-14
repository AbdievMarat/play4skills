@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.lessons.index') }}" class="btn btn-primary btn-sm" title="Назад">
                <i class="bi bi-arrow-left"></i>
            </a>
            Просмотр
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Создано</dt>
                <dd class="col-sm-8">{{ date('d.m.Y H:i', strtotime($lesson->created_at)) }}</dd>
                <dt class="col-sm-4">Изменено</dt>
                <dd class="col-sm-8">{{ date('d.m.Y H:i', strtotime($lesson->updated_at)) }}</dd>
                <dt class="col-sm-4">Название</dt>
                <dd class="col-sm-8">{{ $lesson->name }}</dd>
                <dt class="col-sm-4">Ссылка на обучающий ролик</dt>
                <dd class="col-sm-8"><a href="{!! $lesson->link !!}">{!! $lesson->link !!}</a></dd>
                <dt class="col-sm-4">Содержание</dt>
                <dd class="col-sm-8">{!! $lesson->content !!}</dd>
                <dt class="col-sm-4">Статус</dt>
                <dd class="col-sm-8">{{ $lesson->status }}</dd>
            </dl>
        </div>
    </div>
@endsection
