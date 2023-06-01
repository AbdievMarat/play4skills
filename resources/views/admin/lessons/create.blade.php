@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Создание
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.lessons.store') }}">
                @csrf

                <div class="col-md-12">
                    <x-forms.input type="text" name="name" id="name" label="Название"
                                   placeholder="Заполните название" value="{{ old('name') }}">
                    </x-forms.input>
                </div>
                <div class="col-md-6">
                    <x-forms.input type="url" name="link" id="link" label="Ссылка на обучающий ролик"
                                   placeholder="Заполните ссылку" value="{{ old('link') }}">
                    </x-forms.input>
                </div>
                <div class="col-6">
                    <x-forms.select name="status" id="status" label="Статус"
                                    :options="$statuses"
                                    placeholder="Выберите статус" value="{{ old('status') ?? App\Enums\LessonStatus::Active->value }}">
                    </x-forms.select>
                </div>
                <div class="col-12">
                    <x-forms.tinymce-editor name="content" label="Содержание" value="{{ old('content') }}"></x-forms.tinymce-editor>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
