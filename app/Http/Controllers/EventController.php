<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Event;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        $events = Event::orderBy('start', 'desc')->get();
        return view('event.list', ['events' => $events]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        $event = new Event();
        $event->name = $request->input('name', '');
        $event->area = $request->input('area', '');
        $event->description = $request->input('description', '');
        $event->picture = '';
        $event->start = $this->decodeDate($request->input('start', ''));
        $event->end = $this->decodeDate($request->input('end', ''));
        $event->status = 'closed';
        $event->save();

        return redirect(url('evento/'.$event->id.'/edit'));
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        $event = Event::find($id);
        if ($event == null) {
            return redirect(url('evento'));
        }

        return view('event.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        $event = Event::find($id);
        if ($event == null) {
            return redirect(url('evento'));
        }

        $event->name = $request->input('name', '');
        $event->area = $request->input('area', '');
        $event->description = $request->input('description', '');
        $event->picture = '';
        $event->start = $this->decodeDate($request->input('start', ''));
        $event->end = $this->decodeDate($request->input('end', ''));
        $event->status = $request->input('status', 'closed');
        $event->save();

        return redirect(url('evento'));
    }

    public function destroy($id)
    {
    }

    public function getPhoto($id, $name)
    {
        return response()->download(storage_path() . '/app/photos/' . $id . '/' . $name);
    }

    public function postPhoto(Request $request, $id)
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        echo $request->file('file')->store('photos/' . $id);
    }

    public function deletePhoto($id, $name)
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        $path = storage_path() . '/app/photos/' . $id . '/' . $name;
        @unlink($path);
    }
}
