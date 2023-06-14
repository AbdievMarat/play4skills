@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm" title="Назад">
                <i class="bi bi-arrow-left"></i>
            </a>
            Просмотр
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Создано</dt>
                <dd class="col-sm-8">{{ date('d.m.Y H:i', strtotime($user->created_at)) }}</dd>
                <dt class="col-sm-4">Изменёно</dt>
                <dd class="col-sm-8">{{ date('d.m.Y H:i', strtotime($user->updated_at)) }}</dd>
                <dt class="col-sm-4">Имя</dt>
                <dd class="col-sm-8">{{ $user->name }}</dd>
                <dt class="col-sm-4">Логин</dt>
                <dd class="col-sm-8">{{ $user->email }}</dd>
                <dt class="col-sm-4">Роль</dt>
                <dd class="col-sm-8">
                    @forelse($user->roles as $role)
                        <button class="disabled btn btn-primary">{{ $role->description }}</button>
                    @empty
                        Нет ролей
                    @endforelse
                </dd>
                @if($user->command)
                <dt class="col-sm-4">Команда</dt>
                <dd class="col-sm-8">
                    @foreach($user->command as $command)
                        <button class="disabled btn btn-info">{{ $command }}</button>
                    @endforeach
                </dd>
                @endif
            </dl>
        </div>
    </div>
@endsection
