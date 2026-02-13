<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};

class ApiDocumentationController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Display API documentation page.
     */
    public function index(): View
    {
        return view('api-documentation.index');
    }
}
