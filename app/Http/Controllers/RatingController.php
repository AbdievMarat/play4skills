<?php

namespace App\Http\Controllers;

use App\Enums\AssignedTaskStatus;
use App\Models\ArchivedAssignedTask;
use App\Models\AssignedTask;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
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

        return view('client.rating.index', compact('rating_users', 'archived'));
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

        return view('client.rating.display', compact('rating_users', 'archived'));
    }

    /**
     * @param int $mentorId
     * @param int $archivedAssignedTaskId
     * @return JsonResponse
     */
    public function getMentorUsers(int $mentorId, int $archivedAssignedTaskId): JsonResponse
    {
        $users = User::query()
            ->leftJoin('mentors', 'users.mentor_id', '=', 'mentors.id')
            ->leftJoin('assigned_tasks', function ($join) use ($archivedAssignedTaskId) {
                $join->on('users.id', '=', 'assigned_tasks.user_id')
                    ->where('assigned_tasks.status', '=', AssignedTaskStatus::Completed);

                if ($archivedAssignedTaskId > 0) {
                    $join->where('assigned_tasks.archived_assigned_task_id', '=', $archivedAssignedTaskId);
                } else {
                    $join->whereNull('assigned_tasks.archived_assigned_task_id');
                }
            })
            ->leftJoin('tasks', 'assigned_tasks.task_id', '=', 'tasks.id')
            ->leftJoin('keys', function ($join) {
                $join->on('assigned_tasks.user_id', '=', 'keys.user_id')
                    ->on('assigned_tasks.task_id', '=', 'keys.task_id');
            })
            ->select('users.id', 'users.name', 'users.avatar')
            ->selectRaw('COALESCE(SUM(bonus), 0) + COALESCE(SUM(number_of_points), 0) as total_points')
            ->selectRaw('COALESCE(SUM(keys.amount), 0) as total_keys')
            ->where('users.mentor_id', '=', $mentorId)
            ->groupBy('users.id', 'users.name', 'users.avatar')
            ->orderByDesc('total_points')
            ->get()
            ->toArray();

        return response()->json([
            'content' => view('client.rating.mentor_users', [
                'users' => $users
            ])->render()
        ]);
    }

    /**
     * @param int $userId
     * @param int $archivedAssignedTaskId
     * @return JsonResponse
     */
    public function getPointsDetail(int $userId, int $archivedAssignedTaskId): JsonResponse
    {
        $completedTasks = AssignedTask::query()
            ->leftJoin('tasks', 'assigned_tasks.task_id', '=', 'tasks.id')
            ->leftJoin('keys', function ($join) {
                $join->on('assigned_tasks.user_id', '=', 'keys.user_id')
                    ->on('assigned_tasks.task_id', '=', 'keys.task_id');
            })
            ->select('assigned_tasks.id')
            ->selectRaw('COALESCE(SUM(bonus), 0) + COALESCE(SUM(number_of_points), 0) as points')
            ->selectRaw('COALESCE(SUM(keys.amount), 0) as keys')
            ->where('assigned_tasks.user_id', '=', $userId)
            ->where('status', '=', AssignedTaskStatus::Completed)
            ->when($archivedAssignedTaskId > 0, function ($query) use ($archivedAssignedTaskId) {
                $query->where('assigned_tasks.archived_assigned_task_id', '=', $archivedAssignedTaskId);
            }, function ($query) {
                $query->whereNull('assigned_tasks.archived_assigned_task_id');
            })
            ->groupBy('assigned_tasks.id');

        $assignedTasks = AssignedTask::query()
            ->leftJoinSub($completedTasks, 'completed_tasks', function ($join) use ($archivedAssignedTaskId) {
                $join->on('assigned_tasks.id', '=', 'completed_tasks.id');
            })
            ->leftJoin('tasks', 'assigned_tasks.task_id', '=', 'tasks.id')
            ->select('tasks.name', 'completed_tasks.points', 'completed_tasks.keys')
            ->where('user_id', '=', $userId)
            ->when($archivedAssignedTaskId > 0, function ($query) use ($archivedAssignedTaskId) {
                $query->where('assigned_tasks.archived_assigned_task_id', '=', $archivedAssignedTaskId);
            }, function ($query) {
                $query->whereNull('assigned_tasks.archived_assigned_task_id');
            })
            ->orderBy('assigned_tasks.id', 'desc')
            ->get()
            ->toArray();

        $completedTasksMember = AssignedTask::query()
            ->select('command')
            ->where('user_id', '=', $userId)
            ->where('status', '=', AssignedTaskStatus::Completed)
            ->when($archivedAssignedTaskId > 0, function ($query) use ($archivedAssignedTaskId) {
                $query->where('assigned_tasks.archived_assigned_task_id', '=', $archivedAssignedTaskId);
            }, function ($query) {
                $query->whereNull('assigned_tasks.archived_assigned_task_id');
            })
            ->get()
            ->toArray();

        $totalTaskAssigned = AssignedTask::query()
            ->where('user_id', $userId)
            ->where('status', '=', AssignedTaskStatus::Completed)
            ->when($archivedAssignedTaskId > 0, function ($query) use ($archivedAssignedTaskId) {
                $query->where('assigned_tasks.archived_assigned_task_id', '=', $archivedAssignedTaskId);
            }, function ($query) {
                $query->whereNull('assigned_tasks.archived_assigned_task_id');
            })
            ->count();

        $user = User::findOrFail($userId);

        $userCommand = $user->command;

        $participants = [];

        if ($userCommand) {
            foreach ($userCommand as $participant) {
                $tasksWithParticipant = array_filter($completedTasksMember, function ($task) use ($participant) {
                    return !empty($task['command']) && in_array($participant, $task['command']);

                });
                if (count($tasksWithParticipant) > 0) {
                    $efficiencyPercentage = (count($tasksWithParticipant) / $totalTaskAssigned) * 100;
                }
                $participants[$participant] = $efficiencyPercentage ?? 0;
            }
        }

        return response()->json([
            'modal_content' => view('client.rating.detail', [
                'assignedTasks' => $assignedTasks,
                'participants' => $participants
            ])->render()
        ]);
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
            ->leftJoin('mentors', 'users.mentor_id', '=', 'mentors.id')
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
            ->select('mentors.id', 'mentors.name', 'mentors.avatar')
            ->selectRaw('COALESCE(SUM(bonus), 0) + COALESCE(SUM(number_of_points), 0) as total_points')
            ->selectRaw('COALESCE(SUM(keys.amount), 0) as total_keys')
            ->where('roles.name', '=', 'student')
            ->whereNotNull('mentors.name')
            ->groupBy('mentors.id', 'mentors.name', 'mentors.avatar')
            ->orderByDesc('total_points')
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
