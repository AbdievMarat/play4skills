@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Редактирование
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.lessons.update', ['lesson' => $lesson]) }}">
                @method('PUT')
                @csrf

                <div class="col-md-12">
                    <x-forms.input type="text" name="name" id="name" label="Название"
                                   placeholder="Заполните название" value="{{ old('name') ?? $lesson->name }}">
                    </x-forms.input>
                </div>
                <div class="col-md-6">
                    <x-forms.input type="url" name="link" id="link" label="Ссылка на обучающий ролик"
                                   placeholder="Заполните ссылку" value="{{ old('link') ?? $lesson->link }}">
                    </x-forms.input>
                </div>
                <div class="col-6">
                    <x-forms.select name="status" id="status" label="Статус"
                                    :options="$statuses"
                                    placeholder="Выберите статус" value="{{ old('status') ?? $lesson->status }}">
                    </x-forms.select>
                </div>
                <div class="col-12">
                    <x-forms.tinymce-editor name="content" label="Содержание" value="{{ old('content') ?? $lesson->content }}"></x-forms.tinymce-editor>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Обновить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
