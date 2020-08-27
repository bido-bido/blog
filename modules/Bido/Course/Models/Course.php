<?php

namespace Bido\Course\Models;

use Bido\User\Models\User;
use Bido\Media\Models\Media;
use Bido\Category\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    const TYPE_FREE = 'free';

    const TYPE_CASH = 'cash';

    static $types = [
        self::TYPE_FREE,
        self::TYPE_CASH,
    ];

    const STATUS_COMPLETED = 'completed';

    const STATUS_NOT_COMPLETED = 'not-completed';

    const STATUS_LOCKED = 'locked';

    static $statuses = [
        self::STATUS_COMPLETED,
        self::STATUS_NOT_COMPLETED,
        self::STATUS_LOCKED,
    ];

    const CONFIRMATION_STATUS_ACCEPTED = 'accept';

    const CONFIRMATION_STATUS_REJECTED = 'reject';

    const CONFIRMATION_STATUS_PENDING = 'pending';

    static $confirmationStatuses = [
        self::CONFIRMATION_STATUS_ACCEPTED,
        self::CONFIRMATION_STATUS_REJECTED,
        self::CONFIRMATION_STATUS_PENDING,
    ];

    public function banner()
    {
        return $this->belongsTo(Media::class, 'banner_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}