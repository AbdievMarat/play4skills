<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $content
 * @property int $user_id
 * @property boolean $pinned
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user
 *
 * @mixin Builder
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status',
        'pinned'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('id'), function (Builder $q) {
            $q->where("{$this->getTable()}.id", '=', request('id'));
        });

        $query->when(request('content'), function (Builder $q) {
            $q->where("{$this->getTable()}.content", 'LIKE', '%' . request('content') . '%');
        });

        $query->when(request('user_id'), function (Builder $q) {
            $q->where("{$this->getTable()}.user_id", '=', request('user_id'));
        });

        $query->when(request()->filled('pinned'), function (Builder $q) {
            $q->where("{$this->getTable()}.pinned", '=', request('pinned'));
        });

        $query->when(request('status'), function (Builder $q) {
            $q->where("{$this->getTable()}.status", '=', request('status'));
        });
    }
}
