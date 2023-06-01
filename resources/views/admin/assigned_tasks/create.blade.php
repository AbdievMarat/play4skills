@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Создание
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.assigned_tasks.store') }}">
                @csrf

                <div class="col-md-12">
                    <x-forms.select name="task_id" id="task_id" label="Задание"
                                    :options="$tasks"
                                    placeholder="Выберите задание" value="{{ old('task_id') }}">
                    </x-forms.select>
                </div>
                <div class="col-md-12">
                    <x-forms.select name="user_ids" id="user_ids" label="Исполнитель"
                                    placeholder="Выберите исполнителя" multiple>
                        <option value="All" @selected(in_array('All', old('user_ids') ?? []))>Все</option>
                        @foreach($students as $student_id => $student_name)
                            <option
                                @selected(in_array($student_id, old('user_ids') ?? [])) value="{{ $student_id }}">
                                {{ $student_name }}
                            </option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Поручить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
