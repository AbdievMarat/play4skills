@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.mentors.index') }}" class="btn btn-primary btn-sm" title="Назад">
                <i class="bi bi-arrow-left"></i>
            </a>
            Просмотр
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Создано</dt>
                <dd class="col-sm-8">{{ date('d.m.Y H:i', strtotime($mentor->created_at)) }}</dd>
                <dt class="col-sm-4">Изменёно</dt>
                <dd class="col-sm-8">{{ date('d.m.Y H:i', strtotime($mentor->updated_at)) }}</dd>
                <dt class="col-sm-4">Название</dt>
                <dd class="col-sm-8">{{ $mentor->name }}</dd>
            </dl>
            @if( $mentor->avatar )
                <img src="{{asset('storage/'.$mentor->avatar)}}" class="img-thumbnail mt-3" style="max-width: 350px;"
                     alt="avatar">
            @endif
        </div>
    </div>
@endsection
