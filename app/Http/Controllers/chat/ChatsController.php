<?php

namespace App\Http\Controllers\chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    // public function fetchMessages()
    // {
    //     return Message::with('user')->get();
    // }

    public function store(Request $request)
    {
        $authUser=User::find( Auth::id());
        // $message = User::find( auth()->user()->id)->messages()->create([
        //     'message' => $request->message
        // ]);  
        $message=new Message(); 
        $message->message= $request->message;
        $message->user=$authUser; 
        broadcast(new MessageSent($message->toArray()))->toOthers();

        return ['status' => 'success'];
    }
}
