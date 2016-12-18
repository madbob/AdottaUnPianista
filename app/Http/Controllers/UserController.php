<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;

class UserController extends Controller
{
    public function index()
    {
		$user = Auth::user();
        if ($user == null || $user->admin == false) {
            return redirect(url('/'));
        }

		$users = User::paginate(50);
        return view('user.list', ['users' => $users]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $u = new User();
		$u->name = $request->input('name');
		$u->surname = $request->input('surname');
		$u->phone = $request->input('phone');
		$u->email = $request->input('email');
		$u->password = bcrypt($request->input('password'));
		$u->save();
		return redirect(url('user'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
