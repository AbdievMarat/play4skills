@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Задачи</div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div></div>
                <div>
                    <a href="{{ route('admin.tasks.create') }}" class="btn btn-success float-end">Создать</a>
                </div>
            </div>

            <form action="{{ route('admin.tasks.index') }}" id="search" method="GET"></form>

            <table id="tasks-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Баллы</th>
                    <th>Эврики</th>
                    <th>Важное</th>
                    <th>Крайний срок</th>
                    <th style="width: 160px"></th>
                </tr>
                <tr>
                    <th>
                        <x-input-search type="text" name="id" form="search" value="{{ Request::get('id') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-input-search type="text" name="name" form="search" value="{{ Request::get('name') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-input-search type="text" name="description" form="search"
                                        value="{{ Request::get('description') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-input-search type="text" name="number_of_points" form="search"
                                        value="{{ Request::get('number_of_points') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-input-search type="text" name="number_of_keys" form="search"
                                        value="{{ Request::get('number_of_keys') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-select-search name="important" form="search" :options="['1' => 'да', '0' => 'нет']"
                                         value="{{ Request::get('important') }}">
                        </x-select-search>
                    </th>
                    <th>
                        <x-input-search type="date" name="date_deadline" form="search"
                                        value="{{ Request::get('date_deadline') }}">
                        </x-input-search>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>
                            {{ $task->name }}
                            @if( $task->file )
                                <img src="{{asset('storage/'.$task->file)}}" style="max-width: 50px"
                                     class="img-thumbnail" alt="">
                            @endif
                        </td>
                        <td>{!! $task->description !!}</td>
                        <td>{{ $task->number_of_points }}</td>
                        <td>{{ $task->number_of_keys }}</td>
                        <td>{{ $task->important ? 'Да' : 'Нет' }}</td>
                        <td>{{ date('d.m.Y', strtotime($task->date_deadline)) }} {{ date('H:i', strtotime($task->time_deadline)) }}</td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <div>
                                    <a href="{{ route('admin.tasks.show', ['task' => $task]) }}" type="button"
                                       class="btn btn-success"><i class="bi bi-eye"></i></a>
                                </div>
                                <div class="mx-2">
                                    <a href="{{ route('admin.tasks.edit', ['task' => $task]) }}" type="button"
                                       class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </div>
                                <form action="{{ route('admin.tasks.destroy', ['task' => $task]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-entry"><i
                                            class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="8">
                        {{ $tasks->links() }}
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
