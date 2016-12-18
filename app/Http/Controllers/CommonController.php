<?php

namespace App\Http\Controllers;

use App\Event;

class CommonController extends Controller
{
    public function home()
    {
        $event = Event::where('status', 'published')->first();

        return view('pages.home', ['event' => $event]);
    }
}
