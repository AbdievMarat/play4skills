@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Вопросы</div>
        <div class="card-body">
            <form action="{{ route('admin.questions.index') }}" id="search" method="GET"></form>

            <table id="questions-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Вопрос</th>
                    <th>Отправитель</th>
                    <th>Статус</th>
                    <th style="width: 75px"></th>
                </tr>
                <tr>
                    <th>
                        <x-input-search type="text" name="id" form="search" value="{{ Request::get('id') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-input-search type="text" name="content" form="search" value="{{ Request::get('content') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-select-search name="user_id" form="search" :options="$students"
                                         value="{{ Request::get('user_id') }}">
                        </x-select-search>
                    </th>
                    <th>
                        <x-select-search name="status" form="search" :options="$statuses"
                                         value="{{ Request::get('status') }}">
                        </x-select-search>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->content }}</td>
                        <td><a href="{{ route('admin.users.show', ['user' => $question->user_id]) }}">{{ $question->user->name }}</a></td>
                        <td>{{ $question->status }}</td>
                        <td>
                            @if($question->status == App\Enums\QuestionStatus::Awaiting->value)
                            <div class="d-flex justify-content-end">
                                <div class="mx-2">
                                    <a href="{{ route('admin.questions.edit', ['question' => $question]) }}" type="button"
                                       class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="8">
                        {{ $questions->links() }}
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
