<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
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
        $slot->artist = $request->input('artist', '');
        $slot->contents = $request->input('contents', '');
        $slot->date = $request->input('date', '').' '.$request->input('hour', '');
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
			$slot->artist = $request->input('artist', '');
	        $slot->contents = $request->input('contents', '');
		}

		$slot->save();
		return view('event.cell', ['slot' => $slot->fresh()]);
    }

    public function destroy($id)
    {
    }
}
