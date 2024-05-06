<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @mixin Builder
 */
class Config extends Model
{
    use HasFactory;

    public const CONFIG_QUESTION_ID = 1;
    public const CONFIG_QUESTION_DESCRIPTION_ID = 2;
}
