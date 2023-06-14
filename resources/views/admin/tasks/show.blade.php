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
                <dd class="col-sm-8">{{ date('d.m.Y H:i', strtotime($task->created_at)) }}</dd>
                <dt class="col-sm-4">Изменёно</dt>
                <dd class="col-sm-8">{{ date('d.m.Y H:i', strtotime($task->updated_at)) }}</dd>
                <dt class="col-sm-4">Название</dt>
                <dd class="col-sm-8">{{ $task->name }}</dd>
                <dt class="col-sm-4">Описание</dt>
                <dd class="col-sm-8">{!! $task->description !!}</dd>
                <dt class="col-sm-4">Баллы</dt>
                <dd class="col-sm-8">{{ $task->number_of_points }}</dd>
                <dt class="col-sm-4">Ключи</dt>
                <dd class="col-sm-8">{{ $task->number_of_keys }}</dd>
                <dt class="col-sm-4">Крайний срок</dt>
                <dd class="col-sm-8">{{ date('d.m.Y', strtotime($task->date_deadline)) }}</dd>
                @if( $task->file )
                    <img src="{{asset('storage/'.$task->file)}}" class="img-thumbnail" alt="">
                @endif
            </dl>
        </div>
    </div>
@endsection
