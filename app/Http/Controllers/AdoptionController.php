<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Adoption;

class AdoptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        $locations = Adoption::orderBy('created_at', 'desc')->get();

        return view('adoption.list', ['locations' => $locations]);
    }

    public function create()
    {
        return view('adoption.create', ['location' => new Adoption()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
        ]);

        $adoption = new Adoption();
        $adoption->name = $request->input('name', '');
        $adoption->surname = $request->input('surname', '');
        $adoption->address = $request->input('address', '');
        $adoption->phone = $request->input('phone', '');
        $adoption->email = $request->input('email', '');
        $adoption->notes = $request->input('notes', '');
        $adoption->status = 'pending';
        $adoption->save();

        return view('adoption.thanks');
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

        $location = Adoption::find($id);
        if ($location == null) {
            return redirect(url('adozione'));
        }

        return view('adoption.edit', ['location' => $location]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
        ]);

        $user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

        $location = Adoption::find($id);
        if ($location == null) {
            return redirect(url('adozione'));
        }

        $location->name = $request->input('name', '');
        $location->surname = $request->input('surname', '');
        $location->address = $request->input('address', '');
        $location->phone = $request->input('phone', '');
        $location->email = $request->input('email', '');
        $location->capacity = $request->input('capacity', '0');
        $location->notes = $request->input('notes', '');
        $location->status = $request->input('status', 'pending');
        $location->save();

        return redirect(url('adozione'));
    }

    public function destroy($id)
    {
    }
}
