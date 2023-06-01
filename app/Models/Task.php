<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'file',
        'number_of_points',
        'number_of_keys',
        'date_deadline',
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

        $query->when(request('description'), function (Builder $q) {
            $q->where("{$this->getTable()}.description", 'LIKE', '%' . request('description') . '%');
        });

        $query->when(request('number_of_points'), function (Builder $q) {
            $q->where("{$this->getTable()}.number_of_points", '=', request('number_of_points'));
        });

        $query->when(request('number_of_keys'), function (Builder $q) {
            $q->where("{$this->getTable()}.number_of_points", '=', request('number_of_keys'));
        });

        $query->when(request('date_deadline'), function (Builder $q) {
            $q->where("{$this->getTable()}.date_deadline", '=', request('date_deadline'));
        });
    }
}
