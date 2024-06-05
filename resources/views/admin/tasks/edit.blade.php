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
                <div class="col-md-3">
                    <x-forms.input type="date" name="date_deadline" id="date_deadline" label="Крайний срок"
                                   placeholder="Заполните крайний срок"
                                   value="{{ old('date_deadline') ?? $task->date_deadline }}">
                    </x-forms.input>
                </div>
                <div class="col-3">
                    <x-forms.input type="time" name="time_deadline" id="time_deadline"
                                   label="Время крайнего срока"
                                   placeholder="Заполните время крайнего срока"
                                   value="{{ old('time_deadline') ?? date('H:i', strtotime($task->time_deadline)) }}">
                    </x-forms.input>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <x-forms.input type="number" name="number_of_points" id="number_of_points" label="Баллы"
                                   placeholder="Заполните количество баллов"
                                   value="{{ old('number_of_points') ?? $task->number_of_points }}">
                    </x-forms.input>
                </div>
                <div class="col-md-3">
                    <x-forms.input type="number" name="number_of_keys" id="number_of_keys" label="Эврики"
                                   placeholder="Заполните количество эврик"
                                   value="{{ old('number_of_keys') ?? $task->number_of_keys }}">
                    </x-forms.input>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input type="checkbox" name="important"
                               class="form-check-input @error('important') is-invalid @enderror"
                               id="important" @checked(old('important') ?? $task->important)>
                        <label class="form-check-label" for="important">Важное</label>

                        @error('important')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
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
