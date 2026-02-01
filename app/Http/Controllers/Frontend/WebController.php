<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;


class WebController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }
}
