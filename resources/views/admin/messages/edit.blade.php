@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Редактирование
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.messages.update', ['message' => $message]) }}">
                @method('PUT')
                @csrf

                <div class="col-12">
                    <x-forms.tinymce-editor name="content" label="Сообщение"
                                            value="{{ old('content') ?? $message->content }}"></x-forms.tinymce-editor>
                </div>
                <div class="col-md-12">
                    <div class="form-check">
                        <input type="checkbox" name="pinned"
                               class="form-check-input @error('pinned') is-invalid @enderror"
                               id="pinned" @checked(old('pinned') ?? $message->pinned)>
                        <label class="form-check-label" for="pinned">Прикрепить в чате</label>

                        @error('pinned')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <x-forms.select name="status" id="status" label="Статус"
                                    :options="$statuses"
                                    placeholder="Выберите статус" value="{{ old('status') ?? $message->status }}">
                    </x-forms.select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Обновить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
