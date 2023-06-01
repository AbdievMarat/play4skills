@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Уроки</div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div></div>
                <div>
                    <a href="{{ route('admin.lessons.create') }}" class="btn btn-success float-end">Создать</a>
                </div>
            </div>

            <form action="{{ route('admin.lessons.index') }}" id="search" method="GET"></form>

            <table id="lessons-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Ссылка на обучающий ролик</th>
                    <th>Содержание</th>
                    <th>Статус</th>
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
                        <x-input-search type="text" name="link" form="search" value="{{ Request::get('link') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-input-search type="text" name="content" form="search" value="{{ Request::get('content') }}">
                        </x-input-search>
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
                @foreach($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->id }}</td>
                        <td>{{ $lesson->name }}</td>
                        <td><a href="{!! $lesson->link !!}">{!! $lesson->link !!}</a></td>
                        <td>{!! $lesson->content !!}</td>
                        <td>{{ $lesson->status }}</td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <div>
                                    <a href="{{ route('admin.lessons.show', ['lesson' => $lesson]) }}" type="button"
                                       class="btn btn-success"><i class="bi bi-eye"></i></a>
                                </div>
                                <div class="mx-2">
                                    <a href="{{ route('admin.lessons.edit', ['lesson' => $lesson]) }}" type="button"
                                       class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </div>
                                <form action="{{ route('admin.lessons.destroy', ['lesson' => $lesson]) }}" method="post">
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
                        {{ $lessons->links() }}
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
