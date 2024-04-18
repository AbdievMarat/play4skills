@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            Создание
        </div>
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="col-md-6">
                    <div class="col-md-12">
                        <x-forms.input type="text" name="name" id="name" label="Имя"
                                       placeholder="Заполните имя" value="{{ old('name') }}">
                        </x-forms.input>
                    </div>
                    <div class="col-md-12">
                        <x-forms.input type="text" name="email" id="email" label="Логин"
                                       placeholder="Заполните логин" value="{{ old('email') }}">
                        </x-forms.input>
                    </div>
                    <div class="col-md-12">
                        <x-forms.select name="role_id" id="role_id" label="Роль"
                                        :options="$roles"
                                        placeholder="Выберите роль" value="{{ old('role_id') }}">
                        </x-forms.select>
                    </div>
                    <div class="col-md-12">
                        <x-forms.select name="mentor_id" id="mentor_id" label="Наставник"
                                        :options="$mentors"
                                        placeholder="Выберите наставника" value="{{ old('mentor_id') }}">
                        </x-forms.select>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4>Команда</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2 g-1">
                                    <div class="col-md-12">Наименование</div>
                                </div>
                                @for ($i = 0; $i <= 7; $i++)
                                    <div class="row mb-2 g-1">
                                        <div class="col-md-12">
                                            <input type="text"
                                                   class="form-control @error('command.'.$i) is-invalid @enderror"
                                                   name="command[]" value="{{ old('command.'.$i) }}"
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
                        <x-forms.input type="password" name="password" id="password" label="Пароль"
                                       placeholder="Заполните пароль">
                        </x-forms.input>
                    </div>
                    <div class="col-md-12">
                        <x-forms.input type="password" name="password_confirmation" id="password_confirmation"
                                       label="Подтверждение пароля"
                                       placeholder="Подтвердите пароль">
                        </x-forms.input>
                    </div>
                    <div class="col-md-12">
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">Добавить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
