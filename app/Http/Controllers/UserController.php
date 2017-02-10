<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Archive;

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

    public function sendMail(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == false) {
            return redirect(url('/'));
        }

        $subject = $request->input('subject');
        $text = $request->input('body');

        foreach(User::all() as $user) {
            Mail::send('emails.wrapper', ['text' => $text], function($message) use ($user, $subject) {
                $message->to($user->email);
                $message->subject(env('APP_NAME') . ': ' . $subject);
            });
        }

        Archive::put('Tutti gli iscritti', $subject, $text);

        Session::flash('message', 'Mail inviata agli iscritti');
        return redirect(url('user'));
    }
}
