<?php

namespace App\Http\Controllers;

use App\Enums\AssignedTaskStatus;
use App\Models\AssignedTask;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function index()
    {
        $rating_users = User::query()
            ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
            ->leftJoin('roles', 'users_roles.role_id', '=', 'roles.id')
            ->leftJoin('assigned_tasks', function ($join) {
                $join->on('users.id', '=', 'assigned_tasks.user_id')
                    ->where('assigned_tasks.status', '=', AssignedTaskStatus::Completed);
            })
            ->leftJoin('tasks', 'assigned_tasks.task_id', '=', 'tasks.id')
            ->select('users.id', 'users.name', 'users.avatar', DB::raw('SUM(bonus) + SUM(number_of_points) as total_points'))
            ->where('roles.name', 'student')
            ->groupBy('users.id', 'users.name', 'users.avatar')
            ->orderByDesc('total_points')
            ->get()
            ->toArray();

        if($rating_users) {
            $total_points_max = $rating_users[0]['total_points'];

            foreach ($rating_users as $key => $rating_user) {
                $rating_users[$key]['percentage'] = round((($rating_user['total_points'] ?? 0) / $total_points_max) * 100);
            }
        }

        return view('client.rating.index', compact('rating_users'));
    }

    public function getDetailWithUser(int $userId): JsonResponse
    {
        $completedTasks = AssignedTask::query()
            ->leftJoin('tasks', 'assigned_tasks.task_id', '=', 'tasks.id')
            ->select('assigned_tasks.id', DB::raw('bonus + tasks.number_of_points as points'))
            ->where('user_id', '=', $userId)
            ->where('status', '=', AssignedTaskStatus::Completed);

        $assignedTasks = AssignedTask::query()
            ->leftJoinSub($completedTasks, 'completed_tasks', function ($join) {
                $join->on('assigned_tasks.id', '=', 'completed_tasks.id');
            })
            ->leftJoin('tasks', 'assigned_tasks.task_id', '=', 'tasks.id')
            ->select('tasks.name', 'completed_tasks.points')
            ->where('user_id', '=', $userId)
            ->orderBy('assigned_tasks.id', 'desc')
            ->get()
            ->toArray();

        $completedTasksMember = AssignedTask::query()
            ->select('command')
            ->where('user_id', '=', $userId)
            ->where('status', '=', AssignedTaskStatus::Completed)
            ->get()
            ->toArray();

        $user = User::query()->findOrFail($userId);

        $userCommand = $user->command;
        $totalTaskAssigned = $user->assignedTasks->count();

        $participants = [];

        if($userCommand) {
            foreach ($userCommand as $participant) {
                $tasksWithParticipant = array_filter($completedTasksMember, function ($task) use ($participant) {
                    return !empty($task['command']) && in_array($participant, $task['command']);

                });
                $efficiencyPercentage = (count($tasksWithParticipant) / $totalTaskAssigned) * 100;
                $participants[$participant] = $efficiencyPercentage;
            }
        }

        return response()->json([
            'modal_content' => view('client.rating.detail', [
                'assignedTasks' => $assignedTasks,
                'participants' => $participants
            ])->render()
        ]);
    }
}
