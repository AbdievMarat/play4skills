@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Редактирование
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.questions.update', ['question' => $question]) }}">
                @method('PUT')
                @csrf

                <div class="col-12">
                    {{ $question->content }}
                </div>
                <div class="col-12">
                    <x-forms.select name="status" id="status" label="Статус"
                                    :options="$statuses"
                                    placeholder="Выберите статус" value="{{ old('status') ?? $question->status }}">
                    </x-forms.select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Обновить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
