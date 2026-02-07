<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('is_menu_active')) {
    /**
     * Check if menu is active
     */
    function is_menu_active($route): string
    {
        if (is_array($route)) {
            foreach ($route as $r) {
                if (Route::is($r . '.*') || request()->is($r) || request()->is($r . '/*')) {
                    return 'active';
                }
            }
            return '';
        }

        if (Route::is($route . '.*') || request()->is($route) || request()->is($route . '/*')) {
            return 'active';
        }

        return '';
    }
}

if (!function_exists('is_submenu_active')) {
    /**
     * Check if submenu is active
     */
    function is_submenu_active($route): string
    {
        if (Route::is($route . '.*') || request()->is($route) || request()->is($route . '/*')) {
            return 'active';
        }

        return '';
    }
}
