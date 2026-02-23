<?php

namespace App\Listeners;

use App\Helpers\ActivityLogHelper;
use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
{
    public function handle(Logout $event): void
    {
        if (! config('activitylog.enabled')) {
            return;
        }

        $user = $event->user;

        if (! $user) {
            return;
        }

        ActivityLogHelper::log(
            description: 'User logout',
            logName: 'auth',
            properties: [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'before' => [
                    'logged_out_at' => now()->toIso8601String(),
                ],
                'after' => null,
            ],
            subject: $user
        );
    }
}
