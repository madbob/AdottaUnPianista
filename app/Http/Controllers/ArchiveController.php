<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Archive;

class ArchiveController extends Controller
{
    public function index()
    {
        $messages = Archive::orderBy('created_at', 'desc')->get();
        return view('pages.archive', ['messages' => $messages]);
    }
}
