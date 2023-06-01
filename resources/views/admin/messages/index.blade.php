@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Сообщения</div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div></div>
                <div>
                    <a href="{{ route('admin.messages.create') }}" class="btn btn-success float-end">Создать</a>
                </div>
            </div>

            <form action="{{ route('admin.messages.index') }}" id="search" method="GET"></form>

            <table id="messages-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Сообщение</th>
                    <th>Отправитель</th>
                    <th>Прикрепленный в чате</th>
                    <th>Статус</th>
                    <th style="width: 160px"></th>
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
                        <x-select-search name="user_id" form="search" :options="$users"
                                         value="{{ Request::get('user_id') }}">
                        </x-select-search>
                    </th>
                    <th>
                        <x-select-search name="pinned" form="search" :options="['1' => 'да', '0' => 'нет']"
                                         value="{{ Request::get('pinned') }}">
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
                @foreach($messages as $message)
                    <tr>
                        <td>{{ $message->id }}</td>
                        <td>{!! $message->content !!}</td>
                        <td><a href="{{ route('admin.users.show', ['user' => $message->user_id]) }}">{{ $message->user->name }}</a></td>
                        <td>{{ $message->pinned ? 'Да' : 'Нет' }}</td>
                        <td>{{ $message->status }}</td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <div>
                                    <a href="{{ route('admin.messages.show', ['message' => $message]) }}" type="button"
                                       class="btn btn-success"><i class="bi bi-eye"></i></a>
                                </div>
                                <div class="mx-2">
                                    <a href="{{ route('admin.messages.edit', ['message' => $message]) }}" type="button"
                                       class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </div>
                                <form action="{{ route('admin.messages.destroy', ['message' => $message]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-entry"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="8">
                        {{ $messages->links() }}
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
