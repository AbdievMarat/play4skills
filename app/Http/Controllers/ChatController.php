<?php

namespace App\Http\Controllers;

use App\Enums\ChatStatus;
use App\Http\Requests\StoreChatRequest;
use App\Models\Chat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        $userIdTo = Auth::id();

        $chats = Chat::query()
            ->leftJoin('users', 'chats.user_id_from', '=', 'users.id')
            ->select('chats.user_id_from', 'users.name', 'users.avatar', DB::raw('MAX(chats.updated_at) as updated_at_max'))
            ->where('chats.user_id_to', '=', $userIdTo)
            ->groupBy('chats.user_id_from', 'users.name')
            ->orderBy('updated_at_max', 'desc')
            ->get()
            ->toArray();

        $unreadChats = Chat::query()
            ->select('user_id_to', DB::raw('COUNT(*) as number_of_unread'))
            ->where('user_id_from', '=', $userIdTo)
            ->where('status', '=', ChatStatus::Inactive)
            ->groupBy('user_id_to')
            ->get()
            ->toArray();

        $chats = array_map(function ($chat) use ($unreadChats) {
            $unreadChat = array_filter($unreadChats, fn($u) => $u['user_id_to'] === $chat['user_id_from']);
            $chat['number_of_unread'] = array_shift($unreadChat)['number_of_unread'] ?? 0;

            return $chat;
        }, $chats);

        if(empty($chats) && $userIdTo != 1){
            $chats[] = [
                "user_id_from" => 1,
                "name" => "Поддержка",
                "avatar" => null,
                "updated_at_max" => "",
                "number_of_unread" => "",
                "updated_at_diff" => "",
            ];
        }

        return view('chats.index', compact('chats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($data['is_file']) {
            $path = $data['file']->store('chats', 'public');
            $data['content'] = $path;
        }

        $chat = new Chat($data);
        $chat->status = ChatStatus::Inactive;
        $chat->user_to()->associate($request->user());
        $chat->save();

        return response()->json($chat, 201);
    }

    public function getChatWithUser($userIdFrom): JsonResponse
    {
        $userIdTo = Auth::id();

        $chats = Chat::query()
            ->select('content', 'is_file', 'created_at', DB::raw("CASE WHEN user_id_to = {$userIdTo} THEN 1 ELSE 0 END as to_user"))
            ->where(function ($query) use ($userIdFrom, $userIdTo) {
                $query->where('user_id_from', $userIdFrom)
                    ->where('user_id_to', $userIdTo);
            })
            ->orWhere(function ($query) use ($userIdFrom, $userIdTo) {
                $query->where('user_id_from', $userIdTo)
                    ->where('user_id_to', $userIdFrom);
            })
            ->orderBy('created_at')
            ->get()
            ->toArray();

        if ($chats) {
            Chat::query()
                ->where('user_id_from', '=', $userIdTo)
                ->where('user_id_to', '=', $userIdFrom)
                ->where('status', '=', ChatStatus::Inactive)
                ->update(['status' => ChatStatus::Active]);
        }

        return response()->json([
            'chat_content' => view('chats.chat-content', [
                'chats' => $chats,
            ])->render()
        ]);
    }
}
