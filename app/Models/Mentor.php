<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $avatar
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $users
 *
 * @mixin Builder
 */
class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('id'), function (Builder $q) {
            $q->where("{$this->getTable()}.id", '=', request('id'));
        });

        $query->when(request('name'), function (Builder $q) {
            $q->where("{$this->getTable()}.name", 'LIKE', '%' . request('name') . '%');
        });
    }
}
