<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->latest()->get()->reverse();
        return view('chat.index', compact('messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('chat.index');
    }
}
