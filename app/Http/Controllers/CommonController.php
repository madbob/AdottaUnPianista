<?php

namespace App\Http\Controllers;

use App\Event;

class CommonController extends Controller
{
    public function home()
    {
        $events = Event::whereIn('status', ['announced', 'published'])->orderBy('status', 'start')->get();
        return view('pages.home', ['events' => $events]);
    }
}
