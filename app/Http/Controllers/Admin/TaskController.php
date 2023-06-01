<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTaskRequest;
use App\Http\Requests\Admin\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $tasks = Task::query()
            ->filter()
            ->paginate(10)
            ->withQueryString();

        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $path = $data['file']->store('tasks', 'public');
            $data['file'] = $path;
        }

        $task = new Task($data);
        $task->save();

        return redirect()->route('admin.tasks.index')->with('success', ['text' => 'Успешно добавлено!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $path = $data['file']->store('tasks', 'public');
            $data['file'] = $path;
        }
        if ($request->has('delete_file')) {
            if ($task->file) {
                Storage::delete('public/'.$task->file);
            }
            $data['file'] = null;
        }

        $task->update($data);

        return redirect()->route('admin.tasks.index')->with('success', ['text' => 'Успешно обновлено!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->back()->with('success', ['text' => 'Успешно удалено!']);
    }
}
