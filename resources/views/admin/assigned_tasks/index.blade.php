@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Порученные задания</div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-primary"><i class="bi bi-list-task"></i> Задачи</a>
                <div>
                    <form
                        action="{{ route('admin.assignedTasksArchive') }}"
                        method="post"
                        class="d-inline mx-3"
                    >
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-warning archive"
                        >
                            <i class="bi bi-archive"></i> Архивировать
                        </button>
                    </form>
                    <a href="{{ route('admin.assigned_tasks.create') }}" class="btn btn-success float-end"><i class="bi bi-person-plus-fill"></i> Поручить</a>
                </div>
            </div>

            <form action="{{ route('admin.assigned_tasks.index') }}" id="search" method="GET"></form>

            <table id="assignedTasks-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Задача</th>
                    <th>Исполнитель</th>
                    <th>Комментарий</th>
                    <th>Бонус</th>
                    <th style="width: 135px">Архив</th>
                    <th>Статус</th>
                    <th style="width: 160px"></th>
                </tr>
                <tr>
                    <th>
                        <x-select-search name="task_id" form="search" :options="$tasks"
                                         value="{{ Request::get('task_id') }}">
                        </x-select-search>
                    </th>
                    <th>
                        <x-select-search name="user_id" form="search" :options="$students"
                                         value="{{ Request::get('user_id') }}">
                        </x-select-search>
                    </th>
                    <th>
                        <x-input-search type="text" name="comment" form="search" value="{{ Request::get('comment') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-input-search type="number" name="bonus" form="search"
                                        value="{{ Request::get('bonus') }}">
                        </x-input-search>
                    </th>
                    <th>
                        <x-select-search name="archived_assigned_task_id" form="search" :options="$archived"
                                         value="{{ Request::get('archived_assigned_task_id') }}">
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
                @foreach($assignedTasks as $assignedTask)
                    <tr>
                        <td>
                            <a href="{{ route('admin.tasks.show', ['task' => $assignedTask->task_id]) }}">{{ $assignedTask->task->name }}</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', ['user' => $assignedTask->user_id]) }}">{{ $assignedTask->user->name }}</a>
                        </td>
                        <td>
                            {!! $assignedTask->comment !!}
                            @if( $assignedTask->attached_file )
                                <img src="{{asset('storage/'.$assignedTask->attached_file)}}" class="img-thumbnail"
                                     style="max-width: 300px;" alt="">
                            @endif

                            @if( $assignedTask->command )
                                <p>Список участников:</p>
                                @foreach($assignedTask->command as $participant)
                                    <li>{{ $participant }}</li>
                                @endforeach
                            @endif

                            <br>
                            Создано: {{ date('d.m.Y H:i', strtotime($assignedTask->created_at)) }} <br>
                            Изменено: {{ date('d.m.Y H:i', strtotime($assignedTask->updated_at)) }}
                        </td>
                        <td>{{ $assignedTask->bonus }}</td>
                        <td>{{ $assignedTask->archive->name ?? '' }}</td>
                        <td>
                            <button class="btn btn-primary disabled">{{ $assignedTask->status }}</button>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                @if($assignedTask->status == App\Enums\AssignedTaskStatus::UnderReview->value)
                                    <form
                                        action="{{ route('admin.assignedTasksAccept', ['assigned_task' => $assignedTask]) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success accept"><i
                                                class="bi bi-check-square" title="Принять"></i></button>
                                    </form>

                                    <form
                                        action="{{ route('admin.assignedTasksRevision', ['assigned_task' => $assignedTask]) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning mx-2 revision"><i
                                                class="bi bi-send-check" title="На доработку"></i></button>
                                    </form>
                                @endif


                                @if($assignedTask->status == App\Enums\AssignedTaskStatus::Performed->value)
                                    <form
                                        action="{{ route('admin.assignedTasksUnderReview', ['assigned_task' => $assignedTask]) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-info mx-2 under-review"><i
                                                    class="bi bi-arrow-up-circle" title="Завершить задачу"></i></button>
                                    </form>
                                @endif

                                <form
                                    action="{{ route('admin.assigned_tasks.destroy', ['assigned_task' => $assignedTask]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-entry"><i
                                            class="bi bi-trash3" title="Удалить"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="8">
                        {{ $assignedTasks->links() }}
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
