<?php

namespace App\Mailers;

use App\Notifications\EmailConfirmation;
use App\Notifications\ResetPassword;
use App\User;

class UserMailer extends AbstractMailer
{
    public function sendConfirmationEmail(User $user, $token)
    {
        $user->notify(new EmailConfirmation($token));
    }

    public function sendPasswordReminder(User $user, $token)
    {
        $user->notify(new ResetPassword($token));
    }
}
