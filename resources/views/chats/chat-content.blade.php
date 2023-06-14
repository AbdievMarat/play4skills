@foreach($chats as $chat)
    @if($chat['to_user'] == 1)
        <div class="d-flex flex-row justify-content-start">
            <img
                src="{{ asset('avatar-default.webp') }}"
                alt="avatar" style="width: 45px; height: 100%;">
            <div>
                @if($chat['is_file'])
                    <img src="{{asset('storage/'.$chat['content'])}}" style="max-width: 500px"
                         class="img-thumbnail" alt="">
                @else
                    <p class="small p-2 ms-3 mb-1 rounded-3 bg-secondary bg-opacity-25">{{ $chat['content'] }}</p>
                @endif
                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">{{ date('d.m.Y H:i', strtotime($chat['created_at'])) }}</p>
            </div>
        </div>
    @else
        <div class="d-flex flex-row justify-content-end">
            <div>
                @if($chat['is_file'])
                    <img src="{{asset('storage/'.$chat['content'])}}" style="max-width: 500px"
                         class="img-thumbnail" alt="">
                @else
                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary bg-opacity-75"
                       style="background-color: #f5f6f7;">{{ $chat['content'] }}</p>
                @endif
                <p class="small me-3 mb-3 rounded-3 text-muted">{{ date('d.m.Y H:i', strtotime($chat['created_at'])) }}</p>
            </div>
            <img
                src="{{ asset('avatar-default.webp') }}"
                alt="avatar" style="width: 45px; height: 100%;">
        </div>
    @endif
@endforeach
