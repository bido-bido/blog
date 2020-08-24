<?php

namespace Bido\Course\Rules;

use Bido\User\Repositories\UserRepo;
use Illuminate\Contracts\Validation\ImplicitRule;

class ValidTeacher implements ImplicitRule
{
    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $user = resolve(UserRepo::class)->findById($value);
        return $user->hasPermissionTo('teach');
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return "کاربر انتخاب شده یک مدرس معتبر نمی باشد.";
    }
}