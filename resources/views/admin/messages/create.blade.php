@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Создание
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.messages.store') }}">
                @csrf

                <div class="col-12">
                    <x-forms.tinymce-editor name="content" label="Сообщение"
                                            value="{{ old('content') }}"></x-forms.tinymce-editor>
                </div>
                <div class="col-md-12">
                    <div class="form-check">
                        <input type="checkbox" name="pinned"
                               class="form-check-input @error('pinned') is-invalid @enderror"
                               id="pinned" @checked( old('pinned'))>
                        <label class="form-check-label" for="pinned">Прикрепить в чате</label>

                        @error('pinned')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <x-forms.select name="status" id="status" label="Статус"
                                    :options="$statuses"
                                    placeholder="Выберите статус"
                                    value="{{ old('status') ?? App\Enums\MessageStatus::Active->value }}">
                    </x-forms.select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
