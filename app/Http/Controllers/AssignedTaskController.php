<?php

namespace App\Http\Controllers;

use App\Enums\AssignedTaskStatus;
use App\Http\Requests\UpdateAssignedTaskRequest;
use App\Models\AssignedTask;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignedTaskController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $assignedTasks = Auth::user()->assignedTasks()->with('task')->get();

        $currentDate = Carbon::now()->format('Y-m-d');

        foreach ($assignedTasks as $assignedTask) {
            if ($assignedTask->task->date_deadline < $currentDate) {
                $assignedTask->status = AssignedTaskStatus::Overdue->value;
            }
        }

        return view('client.assigned_tasks.index', compact('assignedTasks'));
    }

    public function edit(AssignedTask $assignedTask): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('client.assigned_tasks.edit', compact('assignedTask'));
    }

    public function update(UpdateAssignedTaskRequest $request, AssignedTask $assignedTask): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('attached_file')) {
            $path = $data['attached_file']->store('assigned_tasks', 'public');
            $data['attached_file'] = $path;
        }
        if ($request->has('delete_file')) {
            if ($assignedTask->attached_file) {
                Storage::delete('public/' . $assignedTask->attached_file);
            }
            $data['attached_file'] = null;
        }
        if (isset($data['command_member'])) {
            foreach ($data['command_member'] as $key => $command) {
                $data['command'][] = $data['command_member_name'][$key];
            }
        } else {
            $data['command'] = [];
        }
        $data['status'] = AssignedTaskStatus::UnderReview;
        $assignedTask->update($data);

        return redirect()->route('assigned_tasks.index')->with('success', ['text' => 'Успешно сохранено!']);
    }
}
