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
 * @property int $amount
 * @property boolean $spent
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Task $task
 * @property-read User $user
 * @property-read Question $questions
 *
 * @mixin Builder
 */
class Key extends Model
{
    use HasFactory;

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questions(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
