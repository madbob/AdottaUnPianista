<?php

namespace App\Http\Controllers;

use App\Event;

class CommonController extends Controller
{
    public function home()
    {
        $year = Event::currentYear();
        $events = Event::whereIn('status', ['announced', 'published', 'archived'])->where('year', $year)->orderBy('status', 'start')->get();
        return view('pages.home', ['events' => $events]);
    }
}
