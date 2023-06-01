<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LessonStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLessonRequest;
use App\Http\Requests\Admin\UpdateLessonRequest;
use App\Models\Lesson;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $lessons = Lesson::query()
            ->filter()
            ->paginate(10)
            ->withQueryString();
        $statuses = LessonStatus::values();

        return view('admin.lessons.index', compact('lessons', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $statuses = LessonStatus::values();

        return view('admin.lessons.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request): RedirectResponse
    {
        $lesson = new Lesson($request->validated());
        $lesson->save();

        return redirect()->route('admin.lessons.index')->with('success', ['text' => 'Успешно добавлено!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $statuses = LessonStatus::values();

        return view('admin.lessons.edit', compact('lesson', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson): RedirectResponse
    {
        $lesson->update($request->validated());

        return redirect()->route('admin.lessons.index')->with('success', ['text' => 'Успешно обновлено!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson): RedirectResponse
    {
        $lesson->delete();

        return redirect()->back()->with('success', ['text' => 'Успешно удалено!']);
    }
}
