@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-primary btn-sm" title="Назад">
                <i class="bi bi-arrow-left"></i>
            </a>
            Просмотр
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Создано</dt>
                <dd class="col-sm-8">{{ date_format(date_create($task->created_at), 'd.m.Y H:i') }}</dd>
                <dt class="col-sm-4">Изменёно</dt>
                <dd class="col-sm-8">{{ date_format(date_create($task->updated_at), 'd.m.Y H:i') }}</dd>
                <dt class="col-sm-4">Название</dt>
                <dd class="col-sm-8">{{ $task->name }}</dd>
                <dt class="col-sm-4">Описание</dt>
                <dd class="col-sm-8">{!! $task->description !!}</dd>
                <dt class="col-sm-4">Баллы</dt>
                <dd class="col-sm-8">{{ $task->number_of_points }}</dd>
                <dt class="col-sm-4">Ключи</dt>
                <dd class="col-sm-8">{{ $task->number_of_keys }}</dd>
                <dt class="col-sm-4">Крайний срок</dt>
                <dd class="col-sm-8">{{ date_format(date_create($task->date_deadline), 'd.m.Y') }}</dd>
                @if( $task->file )
                    <img src="{{asset('storage/'.$task->file)}}" class="img-thumbnail" alt="">
                @endif
            </dl>
        </div>
    </div>
@endsection
