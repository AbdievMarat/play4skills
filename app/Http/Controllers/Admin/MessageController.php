<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMessageRequest;
use App\Http\Requests\Admin\UpdateMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $messages = Message::with('user')
            ->filter()
            ->paginate(20)
            ->withQueryString();
        $users = User::query()->pluck('name', 'id')->toArray();
        $statuses = MessageStatus::values();

        return view('admin.messages.index', compact('messages', 'users', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $statuses = MessageStatus::values();

        return view('admin.messages.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request): RedirectResponse
    {
        $message = new Message($request->validated());
        $message->user()->associate($request->user());
        $message->save();

        return redirect()->route('admin.messages.index')->with('success', ['text' => 'Успешно добавлено!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $statuses = MessageStatus::values();

        return view('admin.messages.edit', compact('message', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message): RedirectResponse
    {
        $message->update($request->validated());

        return redirect()->route('admin.messages.index')->with('success', ['text' => 'Успешно обновлено!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();

        return redirect()->back()->with('success', ['text' => 'Успешно удалено!']);
    }
}
