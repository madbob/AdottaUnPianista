<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Event;
use App\Slot;
use App\Booking;
use App\Attendee;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $id = $request->input('event', 0);
        $event = Event::find($id);
        if ($event == null || $event->status != 'published') {
            return redirect(url('/'));
        }

        return view('booking.create', ['event' => $event, 'user' => $user]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $slot_id = $request->input('slot_id');
        $booking = $user->bookings()->where('slot_id', $slot_id)->first();
        $slot = Slot::findOrFail($slot_id);

        $delete = $request->input('delete-me', false);

        if ($delete) {
            if ($booking != null) {
                $booking->attendees()->delete();
                $booking->delete();
                $booking = null;
            }
        } else {
            $names = $request->input('name');
            $surnames = $request->input('surname');

            if (count($names) > 5) {
                return response()->json(['status' => 'fail', 'error' => 'Sono stati prenotati più posti del consentito', 'available' => $slot->available], 400);
            }

            if ($booking == null) {
                if ($slot->available < count($names)) {
                    return response()->json(['status' => 'fail', 'error' => 'Non ci sono abbastanza posti ancora disponibili', 'available' => $slot->available], 400);
                }

                $booking = new Booking();
                $booking->user_id = $user->id;
                $booking->slot_id = $slot->id;
                $booking->save();

                $attendees = [];
                for ($i = 0; $i < count($names); ++$i) {
                    $n = trim($names[$i]);
                    $s = trim($surnames[$i]);
                    if ($n == '' && $s == '') {
                        continue;
                    }

                    $a = new Attendee();
                    $a->name = $n;
                    $a->surname = $s;
                    $a->booking_id = $booking->id;
                    $a->save();
                }
            } else {
                $attendees = $booking->attendees;

                if ($slot->available + $attendees->count() < count($names)) {
                    return response()->json(['status' => 'fail', 'error' => 'Non ci sono abbastanza posti ancora disponibili', 'available' => $slot->available], 400);
                }

                $confirmed = [];

                for ($i = 0; $i < count($names); ++$i) {
                    $found = false;

                    foreach ($attendees as $a) {
                        if ($a->name == $names[$i] && $a->surname == $surnames[$i]) {
                            $found = true;
                            break;
                        }
                    }

                    if ($found == false) {
                        $n = trim($names[$i]);
                        $s = trim($surnames[$i]);
                        if ($n == '' && $s == '') {
                            continue;
                        }

                        $a = new Attendee();
                        $a->name = $n;
                        $a->surname = $s;
                        $a->booking_id = $booking->id;
                        $a->save();
                    }

                    $confirmed[] = $a->id;
                }

                $booking->attendees()->whereNotIn('id', $confirmed)->delete();
            }
        }

        $slot = $slot->fresh();
        if ($slot->available <= 0) {
            $slot->status = 'full';
            $slot->save();
            $slot = $slot->fresh();
        }

        return view('booking.cell', ['slot' => $slot, 'user' => $user]);
    }

    public function addAttendee(Request $request)
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        /*
            Quando vengono aggiunti nuovi partecipanti a mano, viene creata
            una prenotazione a nome dell'utente (amministratore) che sta
            compiendo l'operazione. In ogni caso, numero di telefono e mail
            devono essere esplicitati
        */

        $slot_id = $request->input('slot_id');
        $booking = $user->bookings()->where('slot_id', $slot_id)->first();
        $slot = Slot::findOrFail($slot_id);

        if ($slot->available == 0) {
            return response()->json(['status' => 'fail', 'error' => 'Non ci sono abbastanza posti ancora disponibili', 'available' => $slot->available], 400);
        }

        if ($booking == null) {
            $booking = new Booking();
            $booking->user_id = $user->id;
            $booking->slot_id = $slot->id;
            $booking->save();
        }

        $a = new Attendee();
        $a->name = $request->input('name');
        $a->surname = $request->input('surname');
        $a->email = $request->input('email');
        $a->phone = $request->input('phone');
        $a->booking_id = $booking->id;
        $a->save();

        return view('event.attendee', ['attendee' => $a]);
    }

    public function removeAttendee(Request $request)
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        $id = $request->input('id');
        $a = Attendee::find($id);
        if ($a != null) {
            /*
                Se viene rimosso l'unico partecipante all'interno di una
                prenotazione, viene rimosso tutto
            */
            $booking = $a->booking;
            if ($booking->attendees()->count() == 1) {
                $booking->delete();
            }

            $a->delete();
        }
    }
}
