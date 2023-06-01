@extends(Auth::user()->hasRole('admin') ? 'layouts.admin' : 'layouts.client')

@section('content')
    <section class="py-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                        <div class="p-3">
                            <div class="input-group rounded mb-3">
                                <input type="search" class="form-control rounded" placeholder="Search"
                                       aria-label="Search"
                                       aria-describedby="search-addon"/>
                                <span class="input-group-text border-0" id="search-addon"><i class="bi bi-search"></i>
                                </span>
                            </div>
                            <div class="border" data-mdb-perfect-scrollbar="true"
                                 style="position: relative; height: 400px; overflow: auto;">
                                <ul class="list-unstyled mb-0">
                                    @foreach($chats as $chat)
                                        <li class="p-2 border-bottom">
                                            <a href="#" class="d-flex justify-content-between chat"
                                               data-user_id_from="{{ $chat['user_id_from'] }}">
                                                <div class="d-flex flex-row">
                                                    <div>
                                                        <img
                                                            src="{{ $chat['avatar'] ? asset('storage/'.$chat['avatar']) : asset('avatar-default.webp') }}"
                                                            alt="avatar" class="d-flex align-self-center me-3"
                                                            width="60">
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="fw-bold mb-0">{{ $chat['name'] }}</p>
                                                        <p class="small text-muted"></p>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    @if($chat['number_of_unread'] > 0)
                                                        <span
                                                            class="badge bg-danger rounded-pill float-end number-of-unread"
                                                            data-user_id_from="{{ $chat['user_id_from'] }}">{{ $chat['number_of_unread'] }}</span>
                                                    @endif
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-7 col-xl-8">
                        <div class="pt-3 pe-3" id="chat-container" data-mdb-perfect-scrollbar="true"
                             style="position: relative; height: 400px; overflow: auto;"></div>
                        <div id="errors" class="is-invalid"></div>
                        <form class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2"
                              id="chat-store" method="POST" action="{{ route('chats.store') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id_from">
                            <input type="hidden" name="is_file">
                            <input type="file" name="file" id="file-input" class="d-none">

                            <img
                                src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('avatar-default.webp') }}"
                                alt="avatar 3" style="width: 40px; height: 100%;">

                            <input type="text" name="content" class="form-control form-control-lg ms-2"
                                   placeholder="Введите сообщение">

                            <a class="ms-1 text-muted" id="file-upload" href="#"><i class="bi bi-paperclip"></i></a>
                            <a class="ms-3" id="submit-chat" href="#"><i class="bi bi-send"></i></a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        @vite(['resources/js/chats.js'])
    @endpush
@endsection
