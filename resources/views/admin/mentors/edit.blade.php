@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Редактирование
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.mentors.update', ['mentor' => $mentor]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="col-md-6">
                    <x-forms.input type="text" name="name" id="name" label="Имя"
                                   placeholder="Заполните имя" value="{{ old('name') ?? $mentor->name }}">
                    </x-forms.input>
                </div>
                <div class="col-md-6">
                    <x-forms.input type="file" name="avatar" id="avatar" label="Аватар"
                                   placeholder="Выберите аватар">
                    </x-forms.input>

                    @if( $mentor->avatar )
                        <img src="{{asset('storage/'.$mentor->avatar)}}" class="img-thumbnail mt-3" style="max-width: 350px;"
                             alt="avatar">

                        <div class="form-check">
                            <input type="checkbox" name="delete_file" class="form-check-input" id="delete_file">
                            <label class="form-check-label" for="delete_file">Удалить аватар</label>
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Обновить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
