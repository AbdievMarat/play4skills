<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AssignedTaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAssignedTaskRequest;
use App\Models\AssignedTask;
use App\Models\Key;
use App\Models\Message;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AssignedTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $assignedTasks = AssignedTask::with('task', 'user')
            ->filter()
            ->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $tasks = Task::query()->pluck('name', 'id')->all();
        $students = User::query()->whereHas('roles', function (Builder $query) {
            $query->where('name', '=', 'student');
        })->pluck('name', 'id')->toArray();
        $statuses = AssignedTaskStatus::values();

        return view('admin.assigned_tasks.index', compact('assignedTasks', 'tasks', 'students', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $tasks = Task::query()->pluck('name', 'id')->all();
        $students = User::query()->whereHas('roles', function (Builder $query) {
            $query->where('name', '=', 'student');
        })->pluck('name', 'id')->toArray();

        return view('admin.assigned_tasks.create', compact('tasks', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignedTaskRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user_ids = $data['user_ids'];

        if(in_array('All', $user_ids)){
            $user_ids = User::query()->whereHas('roles', function (Builder $query) {
                $query->where('name', '=', 'student');
            })->pluck('id')->toArray();
        }

        foreach ($user_ids as $user_id){
            $assignedTask = new AssignedTask();
            $assignedTask->task()->associate($data['task_id']);
            $assignedTask->user()->associate($user_id);
            $assignedTask->status = AssignedTaskStatus::Performed->value;
            $assignedTask->save();
        }

        return redirect()->route('admin.assigned_tasks.index')->with('success', ['text' => 'Успешно поручено!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssignedTask $assignedTask): RedirectResponse
    {
        $assignedTask->delete();

        return redirect()->back()->with('success', ['text' => 'Успешно удалено!']);
    }

    public function accept(Request $request, AssignedTask $assignedTask): RedirectResponse
    {
        $assignedTask->bonus = $request->get('bonus', 0);
        $assignedTask->status = AssignedTaskStatus::Completed->value;
        $assignedTask->update();

        $message = new Message();
        $message->content = "Пользователь {$assignedTask->user->name} завершил задачу.";
        $message->user()->associate($request->user());
        $message->save();

        $key = new Key();
        $key->task()->associate($assignedTask->task_id);
        $key->user()->associate($assignedTask->user_id);
        $key->amount = 1;
        $key->spent = false;
        $key->save();

        return redirect()->back()->with('success', ['text' => 'Принято!']);
    }

    public function revision(Request $request, AssignedTask $assignedTask): RedirectResponse
    {
        $assignedTask->comment_moderator = $request->get('comment_moderator');
        $assignedTask->moderator()->associate($request->user());;
        $assignedTask->status = AssignedTaskStatus::Revision->value;
        $assignedTask->update();

        $message = new Message();
        $message->content = "Задача пользователя {$assignedTask->user->name} возврашена на доработку.";
        $message->user()->associate($request->user());
        $message->save();

        return redirect()->back()->with('success', ['text' => 'Возвращено на доработку!']);
    }
}
