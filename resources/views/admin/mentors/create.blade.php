@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Создание
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.mentors.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="col-md-6">
                    <x-forms.input type="text" name="name" id="name" label="Название"
                                   placeholder="Заполните название" value="{{ old('name') }}">
                    </x-forms.input>
                </div>
                <div class="col-md-6">
                    <x-forms.input type="file" name="avatar" id="avatar" label="Аватар"
                                   placeholder="Выберите аватар">
                    </x-forms.input>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
