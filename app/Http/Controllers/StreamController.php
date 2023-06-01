<?php

namespace App\Http\Controllers;

use App\Enums\MessageStatus;
use App\Enums\QuestionStatus;
use App\Http\Requests\Admin\StoreMessageRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Models\Message;
use App\Models\Question;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class StreamController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $amountKeys = Auth::user()->keys()->where('spent', '=', false)->sum('amount');
        $questions = Auth::user()->questions()->get();
        $messages = Message::query()
            ->select('content', 'created_at')
            ->where('status', '=', MessageStatus::Active)
            ->orderByRaw('pinned DESC, updated_at DESC')
            ->get();

        return view('client.stream.index', compact('amountKeys', 'questions', 'messages'));
    }

    public function storeMessage(StoreMessageRequest $request): RedirectResponse
    {
        $message = new Message($request->validated());
        $message->status = MessageStatus::Active;
        $message->user()->associate($request->user());
        $message->save();

        return redirect()->back()->with('success', ['text' => 'Успешно отправлено!']);
    }

    public function storeQuestion(StoreQuestionRequest $request): RedirectResponse
    {
        $key = Auth::user()->keys()->where('spent', '=', false)->first();
        if ($key) {
            $key->spent = true;
            $key->save();

            $question = new Question($request->validated());
            $question->content = $request->get('question_content');
            $question->status = QuestionStatus::Awaiting;
            $question->key()->associate($key->id);
            $question->user()->associate($request->user());
            $question->save();
        } else {
            return redirect()->back()->with('success', ['text' => 'У Вас недостаточно ключей, чтобы задать вопрос!']);
        }

        return redirect()->back()->with('success', ['text' => 'Успешно отправлено!']);
    }
}
