<?php

namespace Bido\User\Models;

use Bido\Media\Models\Media;
use Bido\Course\Models\Course;
use Bido\RolePermissions\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Bido\User\Notifications\VerifyMailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Bido\User\Notifications\ResetPasswordRequestNotification;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";
    const STATUS_BAN = "ban";

    public static $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_BAN
    ];

    public static $defaultUsers = [
        [
            'email'=>'admin@amdin.com',
            'password'=>'demo',
            'name'=>'Admin',
            'role'=>Role::ROLE_SUPER_ADMIN
        ],
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyMailNotification());
    }

    public function sendResetPasswordNotification()
    {
        $this->notify(new ResetPasswordRequestNotification());
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }
}
