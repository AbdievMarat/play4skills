<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string $content
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @mixin Builder
 */
class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'content',
        'status'
    ];

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('id'), function (Builder $q) {
            $q->where("{$this->getTable()}.id", '=', request('id'));
        });

        $query->when(request('name'), function (Builder $q) {
            $q->where("{$this->getTable()}.name", 'LIKE', '%' . request('name') . '%');
        });

        $query->when(request('link'), function (Builder $q) {
            $q->where("{$this->getTable()}.link", 'LIKE', '%' . request('link') . '%');
        });

        $query->when(request('content'), function (Builder $q) {
            $q->where("{$this->getTable()}.content", 'LIKE', '%' . request('content') . '%');
        });

        $query->when(request('status'), function (Builder $q) {
            $q->where("{$this->getTable()}.status", '=', request('status'));
        });
    }
}
