<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;
use Session;
use PDF;
use App\Event;
use App\Slot;

class SlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
            $user = Auth::user();
            if ($user->admin == false) {
                return redirect(url('/'));
            }

        $this->validate($request, [
            'hour' => 'required|max:255',
            'date' => 'required|max:255',
            'event_id' => 'required|integer',
            'location' => 'required|integer',
        ]);

        $event_id = $request->input('event_id', '');
        $event = Event::find($event_id);
        if ($event == null) {
            return redirect(url('evento'));
        }

        $slot = new Slot();
        $slot->artist = trim($request->input('artist', ''));
        $slot->contents = trim($request->input('contents', ''));
        $slot->date = $request->input('date', '').' '.$request->input('hour', '');
        $slot->name = trim($request->input('name', ''));
        $slot->bookable = ($request->input('bookable', 'true') == 'true');
        $slot->event_id = $event->id;
        $slot->location_id = $request->input('location', '');
        $slot->status = 'open';
        $slot->save();

        return redirect(url('evento/'.$event->id.'/edit'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == false) {
            return redirect(url('/'));
        }

        $slot = Slot::findOrFail($id);

        if ($request->has('location')) {
            $slot->location_id = $request->input('location', '');
        }
        else if ($request->has('void-me')) {
            $slot->status = 'cancelled';
        }
        else {
            $date = explode(' ', $slot->date)[0];
            $slot->date = $date.' '.$request->input('hour', '');
            $slot->name = trim($request->input('name', ''));
            $slot->bookable = ($request->input('bookable', 'true') == 'true');
            $slot->artist = trim($request->input('artist', ''));
            $slot->contents = trim($request->input('contents', ''));
        }

        $slot->save();
        return view('event.cell', ['slot' => $slot->fresh()]);
    }

    public function destroy($id)
    {
    }

    public function sendMail(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == false) {
            return redirect(url('/'));
        }

        $id = $request->input('slot_id');
        $slot = Slot::findOrFail($id);

        $type = $request->input('mail-type');
        switch($type) {
            case 'voided':
                $loggable = '[Mail Standard]';
                $subject = 'concerto annullato';
                $template = 'emails.event_cancelled';
                $parameters = [
                    'slot' => $slot
                ];
                break;

            case 'confirm':
                $loggable = '[Mail Standard]';
                $subject = 'concerto confermato';
                $template = 'emails.event_confirmed';
                $parameters = [
                    'slot' => $slot
                ];
                break;

            case 'custom':
                $loggable = $request->input('manual_body');
                $subject = $request->input('manual_subject');
                $template = 'emails.wrapper';
                $parameters = [
                    'text' => $request->input('manual_body')
                ];
                break;

            default:
                Session::flash('message', 'Mail non inviata!');
                return redirect(url('evento/'.$slot->event->id.'/edit'));
        }

        $notified = [];

        foreach($slot->bookings as $booking) {
            foreach($booking->attendees as $attendee) {
                $email = $attendee->real_mail;
                if (array_key_exists($email, $notified))
                    continue;

                $notified[$email] = true;

                Mail::send($template, $parameters, function($message) use ($email, $subject) {
                    $message->to($email);
                    $message->subject(env('APP_NAME') . ': ' . $subject);
                });
            }
        }

        Archive::put('Tutti i partecipanti a concerto ' . $slot->name, $subject, $loggable);

        Session::flash('message', 'Mail inviata ai partecipanti');
        return redirect(url('evento/'.$slot->event->id.'/edit'));
    }

    public function printable($id)
    {
        $user = Auth::user();
        if ($user->admin == false) {
            return redirect(url('/'));
        }

        $slot = Slot::findOrFail($id);
        $html = view('event.printable', ['slot' => $slot])->render();

        $name = sprintf('Partecipanti concerto %s', $slot->printableDate() . ' ' . $slot->printableHour());
        $filename = $name . 'pdf';
        PDF::SetTitle($name);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($filename, 'D');
    }
}
