<?php

namespace Combindma\Richcms\Traits;

use Combindma\Richcms\Enums\Roles;
use Combindma\Richcms\Notifications\NewAccount;
use Combindma\Richcms\Notifications\NewPassword;
use Combindma\Richcms\Notifications\ResetPassword;
use Combindma\Richcms\Notifications\VerifyMail;
use Illuminate\Support\Facades\Hash;

trait UserTrait
{
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyMail());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function sendNewAccountNotification($password)
    {
        $this->notify(new NewAccount($password));
    }

    public function sendNewPasswordNotification($password)
    {
        $this->notify(new NewPassword($password));
    }

    public static function create(array $attributes)
    {
        $query = static::query();
        $user = $query->create(array_merge($attributes, ['password' => Hash::make($attributes['password'])]));
        if (! empty($attributes['role'])) {
            $user->assignRole($attributes['role']);
        } else {
            $user->assignRole(Roles::Client);
        }

        return $user;
    }

    public function updatePassword($password)
    {
        $this->password = Hash::make($password);
        $this->save();

        return $this;
    }
}
