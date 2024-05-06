<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\ChatStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $command
 * @property string|null $avatar
 * @property boolean $access_sent
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $decrypted_password
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Role $roles
 * @property-read Message $messages
 * @property-read Question $questions
 * @property-read AssignedTask $assignedTasks
 * @property-read Key $keys
 * @property-read Chat $chats
 * @property-read Mentor $mentor
 *
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'decrypted_password',
        'command',
        'mentor_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'command' => 'json'
    ];

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(AssignedTask::class);
    }

    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'user_id_from');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class);
    }

    /**
     * @param $role
     * @return mixed
     */
    public function hasRole($role): mixed
    {
        return $this->roles()->where('name', '=', $role)->first();
    }

    public function getUnreadMessageCount(): int
    {
        return $this->chats()->where('status', ChatStatus::Inactive)->count();
    }

    public function scopeFilter(Builder $query): void
    {
        $query->when(request('id'), function (Builder $q) {
            $q->where("{$this->getTable()}.id", '=', request('id'));
        });

        $query->when(request('mentor_id'), function (Builder $q) {
            $q->where("{$this->getTable()}.mentor_id", '=', request('mentor_id'));
        });

        $query->when(request('name'), function (Builder $q) {
            $q->where("{$this->getTable()}.name", 'LIKE', '%' . request('name') . '%');
        });

        $query->when(request('email'), function (Builder $q) {
            $q->where("{$this->getTable()}.email", 'LIKE', '%' . request('email') . '%');
        });
    }
}
