<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->oldest()->get();
        return view('chat.index', compact('messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // RESPONSE UNTUK POSTMAN / AJAX
        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);
        }

        // RESPONSE UNTUK BROWSER
        return redirect()->route('chat.index');
    }
}
