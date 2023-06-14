@extends('layouts.client')

@section('content')
    <div class="accordion container-fluid py-4">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                        aria-controls="panelsStayOpen-collapseOne">
                    {{ $assignedTask->task->name }}
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                 aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    {!! $assignedTask->task->description !!}

                    <hr>
                    <b>Баллов за задание:</b> {{ $assignedTask->task->number_of_points }} <br>
                    <b>Ключей за задание:</b> {{ $assignedTask->task->number_of_keys }} <br>
                    <b>Крайник срок:</b> {{ date('d.m.Y', strtotime($assignedTask->task->date_deadline)) }}
                </div>
            </div>
        </div>
        @if( $assignedTask->task->file )
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                            aria-controls="panelsStayOpen-collapseTwo">
                        Приложение
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show"
                     aria-labelledby="panelsStayOpen-headingTwo">
                    <div class="accordion-body">
                        <img class="img-fluid" src="{{asset('storage/'.$assignedTask->task->file)}}" style="max-width: 370px;" alt="">
                    </div>
                </div>
            </div>
        @endif

        @if( $assignedTask->status == App\Enums\AssignedTaskStatus::Revision->value )
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingCommentModerator">
                    <button class="accordion-button bg-warning" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-CommentModerator" aria-expanded="false"
                            aria-controls="panelsStayOpen-CommentModerator">
                        Комментарий модератора
                    </button>
                </h2>
                <div id="panelsStayOpen-CommentModerator" class="accordion-collapse collapse show"
                     aria-labelledby="panelsStayOpen-CommentModerator">
                    <div class="accordion-body">
                        {{ $assignedTask->comment_moderator }}
                    </div>
                </div>
            </div>
        @endif
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                        aria-controls="panelsStayOpen-collapseThree">
                    Выполнение задания
                </button>
            </h2>
            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show"
                 aria-labelledby="panelsStayOpen-headingThree">
                <div class="accordion-body">
                    <form class="row g-3" method="POST" action="{{ route('assigned_tasks.update', ['assigned_task' => $assignedTask]) }}"
                          enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <span class="h2">Список участников</span>

                        <ul class="list-group">
                            @foreach(Auth::user()->command as $key => $command_member)
                                <li class="list-group-item">
                                    <label>
                                        <input class="form-check-input me-3" type="checkbox" name="command_member[{{ $key }}]" @checked(in_array($command_member, $assignedTask->command ?? []))  />
                                        <input type="hidden" name="command_member_name[{{ $key }}]" value="{{ $command_member }}" />
                                        {{ $command_member }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>

                        <hr>

                        <x-forms.tinymce-editor name="comment" label="Комментарий"
                                                value="{{ old('comment') ?? $assignedTask->comment }}"></x-forms.tinymce-editor>

                        @if( $assignedTask->attached_file )
                            <img src="{{asset('storage/'.$assignedTask->attached_file)}}" class="img-thumbnail" style="max-width: 400px;" alt="">

                            <div class="form-check">
                                <input type="checkbox" name="delete_file" class="form-check-input" id="delete_file">
                                <label class="form-check-label" for="delete_file">Удалить файл</label>
                            </div>
                        @endif

                        <x-forms.input type="file" name="attached_file" id="attached_file" label="Файл"
                                       placeholder="Выберите файл">
                        </x-forms.input>

                        <button type="submit" class="btn btn-success mt-2">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
