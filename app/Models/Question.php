<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function key(): BelongsTo
    {
        return $this->belongsTo(Key::class);
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

        $query->when(request('status'), function (Builder $q) {
            $q->where("{$this->getTable()}.status", '=', request('status'));
        });
    }
}
