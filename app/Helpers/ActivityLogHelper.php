<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class ActivityLogHelper
{
    /**
     * Log activity with pretty JSON format for before/after data.
     */
    public static function log(
        string $description,
        ?string $logName = 'default',
        array $properties = [],
        $subject = null
    ): void {
        if (! config('activitylog.enabled')) {
            return;
        }

        $logger = activity($logName)->withProperties($properties);

        if (Auth::check()) {
            $logger->causedBy(Auth::user());
        }

        if ($subject) {
            $logger->performedOn($subject);
        }

        $logger->log($description);
    }

    /**
     * Format properties as pretty JSON for display.
     */
    public static function formatPropertiesForDisplay($properties): string
    {
        if (is_array($properties)) {
            return json_encode($properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        if (is_object($properties) && method_exists($properties, 'toArray')) {
            return json_encode($properties->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return (string) $properties;
    }
}
