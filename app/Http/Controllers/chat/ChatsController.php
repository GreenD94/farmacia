<?php

namespace App\Http\Controllers\chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;

class ChatsController extends Controller
{

    // public function fetchMessages()
    // {
    //     return Message::with('user')->get();
    // }

    public function store(Request $request)
    {
        // $message = User::find( auth()->user()->id)->messages()->create([
        //     'message' => $request->message
        // ]);

        //broadcast(new MessageSent($message->load('user')))->toOthers();

        return ['status' => 'success'];
    }
}
