<?php

namespace App\Listeners;

use App\Helpers\ActivityLogHelper;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        if (! config('activitylog.enabled')) {
            return;
        }

        $user = $event->user;

        ActivityLogHelper::log(
            description: 'User login',
            logName: 'auth',
            properties: [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'before' => null,
                'after' => [
                    'logged_in_at' => now()->toIso8601String(),
                ],
            ],
            subject: $user
        );
    }
}
