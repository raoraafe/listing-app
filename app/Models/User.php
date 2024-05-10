<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use CrudTrait;
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
    ];
    /**
     * Get the users associated with the role.
     */
    public function userRole(): BelongsToMany
    {
        return $this->belongsToMany(UserRole::class, 'user_role_user');
    }

    public static function getUserCountByRole(string $role)
    {
        return self::whereHas('userRole', function ($query) use ($role) {
            $query->where('name', $role);
        })->count();
    }

    public static function userCountByRoleWidgetArray(int $count, int $target, array $options): array
    {
        $progress = ($count / $target) * 100;
        return [
            'type'          => 'progress',
            'class'         => $options['class'],
            'value'         => $count,
            'description'   => $options['description'],
            'progress'      => $progress,
            'progressClass' => 'progress-bar bg-primary',
            'hint'          => ($target - $count) . ' more until next milestone.',
        ];
    }
}
