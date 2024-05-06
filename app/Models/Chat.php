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
 * @property boolean $is_file
 * @property int $user_id_from
 * @property int $user_id_to
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $user_from
 * @property-read User $user_to
 *
 * @mixin Builder
 */
class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id_from',
        'is_file',
        'content'
    ];

    public function user_from(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_from');
    }

    public function user_to(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_to');
    }
}
