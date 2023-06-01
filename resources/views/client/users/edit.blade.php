@extends('layouts.client')

@section('content')
    <div class="card">
        <div class="card-header">
            Редактирование
        </div>
        <div class="card-body">
            @if(Auth::user()->command === null || count(Auth::user()->command) < 3)
                <div class="alert alert-primary" role="alert">
                    Минимальное количество участников команды должно быть 3 человека.
                </div>
            @endif

            <form class="row g-3" method="POST" action="{{ route('users.update', ['user' => Auth::user()]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="col-md-6">
                    <div class="col-md-12">
                        <label for="name" class="form-label">Имя</label>
                        <input class="form-control" type="text" id="name" value="{!! $user->name !!}" disabled>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4>Команда</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2 g-1">
                                    <div class="col-md-12">Имена сотрудников</div>
                                </div>
                                @for ($i = 0; $i <= 4; $i++)
                                    <div class="row mb-2 g-1">
                                        <div class="col-md-12">
                                            <input type="text"
                                                   class="form-control @error('command.'.$i) is-invalid @enderror"
                                                   name="command[]"
                                                   value="{{ old('command.'.$i) !== null ? old('command.'.$i) : ($user->command[$i] ?? '') }}"
                                                   autocomplete="off">

                                            @error('command.'.$i)
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="col-md-12">
                        <label for="name" class="form-label">Почта</label>
                        <input class="form-control" type="text" id="name" value="{{ $user->email }}" disabled>
                    </div>

                    <x-forms.input type="file" name="avatar" id="avatar" label="Аватар"
                                   placeholder="Выберите аватар">
                    </x-forms.input>

                    @if( $user->avatar )
                        <img src="{{asset('storage/'.$user->avatar)}}" class="img-thumbnail mt-3" style="max-width: 400px;"
                             alt="avatar">

                        <div class="form-check">
                            <input type="checkbox" name="delete_file" class="form-check-input" id="delete_file">
                            <label class="form-check-label" for="delete_file">Удалить аватар</label>
                        </div>
                    @endif
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">Обновить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
