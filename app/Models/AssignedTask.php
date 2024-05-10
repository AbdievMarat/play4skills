<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string|null $command
 * @property string|null $comment
 * @property string|null $attached_file
 * @property int $bonus
 * @property string|null $comment_moderator
 * @property int|null $user_id_moderator
 * @property string $status
 * @property string $archived_assigned_task_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Task $task
 * @property-read User $user
 * @property-read User $moderator
 * @property-read ArchivedAssignedTask $archive
 *
 * @mixin Builder
 */
class AssignedTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'command',
        'comment',
        'attached_file',
        'status'
    ];
    protected $casts = [
        'command' => 'json'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_moderator');
    }

    public function archive(): BelongsTo
    {
        return $this->belongsTo(ArchivedAssignedTask::class, 'archived_assigned_task_id');
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('task_id'), function (Builder $q) {
            $q->where("{$this->getTable()}.task_id", '=', request('task_id'));
        });

        $query->when(request('user_id'), function (Builder $q) {
            $q->where("{$this->getTable()}.user_id", '=', request('user_id'));
        });

        $query->when(request('comment'), function (Builder $q) {
            $q->where("{$this->getTable()}.comment", 'LIKE', '%' . request('comment') . '%');
        });

        $query->when(request('bonus'), function (Builder $q) {
            $q->where("{$this->getTable()}.bonus", '=', request('bonus'));
        });

        $query->when(request('status'), function (Builder $q) {
            $q->where("{$this->getTable()}.status", '=', request('status'));
        });

        $query->when(request('archived_assigned_task_id'), function (Builder $q) {
            $q->where("{$this->getTable()}.archived_assigned_task_id", '=', request('archived_assigned_task_id'));
        });
    }
}
