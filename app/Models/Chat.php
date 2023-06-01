<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
