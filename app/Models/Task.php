<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $file
 * @property int $number_of_points
 * @property int $number_of_keys
 * @property boolean $important
 * @property Carbon $date_deadline
 * @property string $time_deadline
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read AssignedTask $assignedTasks
 * @property-read Key $keys
 *
 * @mixin Builder
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'file',
        'number_of_points',
        'number_of_keys',
        'important',
        'date_deadline',
        'time_deadline',
    ];

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(AssignedTask::class);
    }

    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('id'), function (Builder $q) {
            $q->where("{$this->getTable()}.id", '=', request('id'));
        });

        $query->when(request('name'), function (Builder $q) {
            $q->where("{$this->getTable()}.name", 'LIKE', '%' . request('name') . '%');
        });

        $query->when(request('description'), function (Builder $q) {
            $q->where("{$this->getTable()}.description", 'LIKE', '%' . request('description') . '%');
        });

        $query->when(request('number_of_points'), function (Builder $q) {
            $q->where("{$this->getTable()}.number_of_points", '=', request('number_of_points'));
        });

        $query->when(request('number_of_keys'), function (Builder $q) {
            $q->where("{$this->getTable()}.number_of_points", '=', request('number_of_keys'));
        });

        $query->when(request()->filled('important'), function (Builder $q) {
            $q->where("{$this->getTable()}.important", '=', request('important'));
        });

        $query->when(request('date_deadline'), function (Builder $q) {
            $q->where("{$this->getTable()}.date_deadline", '=', request('date_deadline'));
        });
    }
}
