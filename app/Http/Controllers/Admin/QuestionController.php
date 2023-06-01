<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QuestionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $questions = Question::with('user')
            ->filter()
            ->paginate(20)
            ->withQueryString();
        $students = User::query()->whereHas('roles', function (Builder $query) {
            $query->where('name', '=', 'student');
        })->pluck('name', 'id')->toArray();
        $statuses = QuestionStatus::values();

        return view('admin.questions.index', compact('questions','students', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $statuses = QuestionStatus::values();

        return view('admin.questions.edit', compact('question', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question): RedirectResponse
    {
        $question->update($request->validated());

        if($request->get('status') == QuestionStatus::Incorrect->value){
            $key = $question->key()->first();
            $key->spent = false;
            $key->save();
        }

        return redirect()->route('admin.questions.index')->with('success', ['text' => 'Успешно обновлено!']);
    }
}
