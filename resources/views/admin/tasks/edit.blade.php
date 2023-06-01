@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Редактирование
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.tasks.update', ['task' => $task]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="col-md-6">
                    <x-forms.input type="text" name="name" id="name" label="Название"
                                   placeholder="Заполните название" value="{{ old('name') ?? $task->name }}">
                    </x-forms.input>
                </div>
                <div class="col-md-6">
                    <x-forms.input type="date" name="date_deadline" id="date_deadline" label="Крайний срок"
                                   placeholder="Заполните крайний срок"
                                   value="{{ old('date_deadline') ?? $task->date_deadline }}">
                    </x-forms.input>
                </div>
                <div class="col-md-4">
                    @if( $task->file )
                        <img src="{{asset('storage/'.$task->file)}}" class="img-thumbnail" alt="">

                        <div class="form-check">
                            <input type="checkbox" name="delete_file" class="form-check-input" id="delete_file">
                            <label class="form-check-label" for="delete_file">Удалить файл</label>
                        </div>
                    @endif
                    <x-forms.input type="file" name="file" id="file" label="Файл"
                                   placeholder="Выберите файл">
                    </x-forms.input>
                </div>
                <div class="col-md-4">
                    <x-forms.input type="number" name="number_of_points" id="number_of_points" label="Баллы"
                                   placeholder="Заполните количество баллов"
                                   value="{{ old('number_of_points') ?? $task->number_of_points }}">
                    </x-forms.input>
                </div>
                <div class="col-md-4">
                    <x-forms.input type="number" name="number_of_keys" id="number_of_keys" label="Ключи"
                                   placeholder="Заполните количество ключей"
                                   value="{{ old('number_of_keys') ?? $task->number_of_keys }}">
                    </x-forms.input>
                </div>
                <div class="col-12">
                    <x-forms.tinymce-editor name="description" label="Описание"
                                            value="{{ old('description') ?? $task->description }}"></x-forms.tinymce-editor>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Обновить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
