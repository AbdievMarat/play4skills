<?php

namespace App\Http\Controllers;

use App\Enums\AssignedTaskStatus;
use App\Models\ArchivedAssignedTask;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class RatingUserController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function index(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $archivedAssignedTaskId = (int)$request['archived_assigned_task_id'];
        $rating_users = $this->getUsers($archivedAssignedTaskId);
        $archived = ArchivedAssignedTask::query()
            ->pluck('name', 'id')
            ->all();

        return view('client.rating_user.index', compact('rating_users', 'archived'));
    }

    /**
     * @param Request $request
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function display(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $archivedAssignedTaskId = (int)$request['archived_assigned_task_id'];
        $rating_users = $this->getUsers($archivedAssignedTaskId);
        $archived = ArchivedAssignedTask::query()
            ->pluck('name', 'id')
            ->all();

        return view('client.rating_user.display', compact('rating_users', 'archived'));
    }

    /**
     * @param int $archivedAssignedTaskId
     * @return array
     */
    private function getUsers(int $archivedAssignedTaskId = 0): array
    {
        $rating_users = User::query()
            ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
            ->leftJoin('roles', 'users_roles.role_id', '=', 'roles.id')
            ->leftJoin('assigned_tasks', function ($join) use ($archivedAssignedTaskId) {
                $join->on('users.id', '=', 'assigned_tasks.user_id')
                    ->where('assigned_tasks.status', '=', AssignedTaskStatus::Completed);

                if ($archivedAssignedTaskId > 0) {
                    $join->where('assigned_tasks.archived_assigned_task_id', '=', $archivedAssignedTaskId);
                } else {
                    $join->whereNull('assigned_tasks.archived_assigned_task_id');
                }
            })
            ->leftJoin('keys', function ($join) {
                $join->on('assigned_tasks.user_id', '=', 'keys.user_id')
                    ->on('assigned_tasks.task_id', '=', 'keys.task_id');
            })
            ->leftJoin('tasks', 'assigned_tasks.task_id', '=', 'tasks.id')
            ->select('users.id', 'users.name', 'users.avatar')
            ->selectRaw('COALESCE(SUM(bonus), 0) + COALESCE(SUM(number_of_points), 0) as total_points')
            ->selectRaw('COALESCE(SUM(keys.amount), 0) as total_keys')
            ->where('roles.name', '=', 'student')
            ->groupBy('users.id', 'users.name', 'users.avatar')
            ->orderByDesc('total_points')
            ->orderByDesc('users.avatar')
            ->orderBy('users.name')
            ->get()
            ->toArray();

        if ($rating_users) {
            $total_points_max = $rating_users[0]['total_points'];

            foreach ($rating_users as $key => $rating_user) {
                if ($total_points_max > 0) {
                    $rating_users[$key]['percentage'] = round((($rating_user['total_points'] ?? 0) / $total_points_max) * 100);
                } else {
                    $rating_users[$key]['percentage'] = 0;
                }
            }
        }
        return $rating_users;
    }
}
