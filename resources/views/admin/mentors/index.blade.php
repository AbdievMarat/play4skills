@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Задачи</div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div></div>
                <div>
                    <a href="{{ route('admin.mentors.create') }}" class="btn btn-success float-end">Создать</a>
                </div>
            </div>

            <form action="{{ route('admin.mentors.index') }}" id="search" method="GET"></form>

            <table id="tasks-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
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
                    <th></th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($mentors as $mentor)
                    <tr>
                        <td>{{ $mentor->id }}</td>
                        <td>{{ $mentor->name }}</td><td>
                            <div class="d-flex justify-content-end">
                                <div>
                                    <a href="{{ route('admin.mentors.show', ['mentor' => $mentor]) }}" type="button"
                                       class="btn btn-success"><i class="bi bi-eye"></i></a>
                                </div>
                                <div class="mx-2">
                                    <a href="{{ route('admin.mentors.edit', ['mentor' => $mentor]) }}" type="button"
                                       class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </div>
                                <form action="{{ route('admin.mentors.destroy', ['mentor' => $mentor]) }}" method="post">
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
                        {{ $mentors->links() }}
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
