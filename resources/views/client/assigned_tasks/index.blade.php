@extends('layouts.client')

@section('content')
    <section class="vh-100" style="background-color: #eee;">
        <div class="container-fluid h-100 overflow-auto">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-12 col-xl-10">

                    @if(Auth::user()->command === null || count(Auth::user()->command) < 3)
                        <div class="alert alert-primary mt-3" role="alert">
                            <h4 class="alert-heading">
                                Перед началом выполнения заданий, необходимо заполнить список участников команды в
                                <a href="{{ route('users.edit', ['user' => Auth::user()]) }}" class="alert-link">
                                    личном кабинете
                                </a>!
                            </h4>
                            Минимальное количество участников команды должно быть 3 человека.
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header p-3">
                            <h5 class="mb-0"><i class="bi bi-list-task"></i> Список заданий</h5>
                        </div>
                        <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; overflow: auto;">

                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">Название</th>
                                    <th scope="col">Крайний срок</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col" class="text-center">Выполнить</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assignedTasks as $assignedTask)
                                    <tr class="fw-normal">
                                        <th>
                                            {{ $assignedTask->task->name }}
                                        </th>
                                        <td>{{ date('d.m.Y', strtotime($assignedTask->task->date_deadline)) }}</td>
                                        <td>
                                            <h6 class="mb-0"><span class="badge {{ App\Enums\AssignedTaskStatus::from($assignedTask->status)->colorClass() }}">
                                                    {{ $assignedTask->status }}
                                                    @if($assignedTask->status == App\Enums\AssignedTaskStatus::Revision->value)
                                                        <p>Комментарий модератора: {{ $assignedTask->comment_moderator }}</p>
                                                    @endif
                                                </span>
                                            </h6>
                                        </td>
                                        <td>
                                            @if(
                                                Auth::user()->command !== null &&
                                                count(Auth::user()->command) >= 3 &&
                                                in_array($assignedTask->status, [App\Enums\AssignedTaskStatus::Performed->value, App\Enums\AssignedTaskStatus::UnderReview->value, App\Enums\AssignedTaskStatus::Revision->value]) &&
                                                $assignedTask->task->date_deadline > date('Y-m-d')
                                            )
                                                <div class="text-center">
                                                    <a href="{{ route('assigned_tasks.edit', ['assigned_task' => $assignedTask]) }}"
                                                       type="button"
                                                       class="btn btn-success"><i class="bi bi-pencil-square"></i></a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
