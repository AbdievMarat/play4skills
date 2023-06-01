@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.messages.index') }}" class="btn btn-primary btn-sm" title="Назад">
                <i class="bi bi-arrow-left"></i>
            </a>
            Просмотр
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Создано</dt>
                <dd class="col-sm-8">{{ date_format(date_create($message->created_at), 'd.m.Y H:i') }}</dd>
                <dt class="col-sm-4">Изменёно</dt>
                <dd class="col-sm-8">{{ date_format(date_create($message->updated_at), 'd.m.Y H:i') }}</dd>
                <dt class="col-sm-4">Наименование</dt>
                <dd class="col-sm-8">{!! $message->content !!}</dd>
                <dt class="col-sm-4">Статус</dt>
                <dd class="col-sm-8">{{ $message->status }}</dd>
            </dl>
        </div>
    </div>
@endsection
