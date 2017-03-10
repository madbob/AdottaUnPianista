<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Log;
use Image;
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
        $event->name = trim($request->input('name', ''));
        $event->area = trim($request->input('area', ''));
        $event->description = trim($request->input('description', ''));
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

        $event->name = trim($request->input('name', ''));
        $event->area = trim($request->input('area', ''));
        $event->description = trim($request->input('description', ''));
        $event->picture = '';
        $event->start = $this->decodeDate($request->input('start', ''));
        $event->end = $this->decodeDate($request->input('end', ''));
        $event->status = $request->input('status', 'closed');
        $event->save();

        return redirect(url('evento'));
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

        $file = $request->file('file');
        $path = 'photos/' . $id . '/' . str_random(10);
        Image::make($file->getRealPath())->widen(800)->save(storage_path() . '/app/' . $path);
        echo $path;
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

    public function sendMail(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == false) {
            return redirect(url('/'));
        }

        $id = $request->input('event_id');
        $event = Event::findOrFail($id);

        $subject = $request->input('subject');
        $text = $request->input('body');
        $notified = [];

        foreach($event->slots as $slot) {
            foreach($slot->bookings as $booking) {
                foreach($booking->attendees as $attendee) {
                    $email = $attendee->real_mail;
                    if (array_key_exists($email, $notified))
                        continue;

                    $notified[$email] = true;

                    try {
                        Mail::send('emails.wrapper', ['text' => $text], function($message) use ($email, $subject) {
                            $message->to($email);
                            $message->subject(env('APP_NAME') . ': ' . $subject);
                        });
                    }
                    catch(\Exception $e) {
                        Log::error("Mail evento non inviata a $email: " . $e->getMessage());
                    }
                }
            }
        }

        Archive::put('Tutti i partecipanti a evento ' . $event->name, $subject, $text);

        Session::flash('message', 'Mail inviata ai partecipanti');
        return redirect(url('evento/'.$slot->event->id.'/edit'));
    }
}
