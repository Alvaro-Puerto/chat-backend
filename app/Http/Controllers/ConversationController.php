<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Events\OnlineEvent;
use App\Events\UserOnlineEvent;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    //
    public function index() {
       $conversations = User::find(Auth::user()->id)
                             ->conversation()
                             ->with('getLastMessage')
                             ->get();

                           
        return response()->json($conversations);
    }

    public function show($id) {
        
        $user = User::find(Auth::user()->id);
       
        $conversation = $user->getConversationWithUser($id);
        
        if(!$conversation) {
            $conversation = new Conversation();
            $conversation->name = 'Sin conversacion';
        }
        $conversation->message;
        //broadcast(new UserOnlineEvent());

        return response()->json($conversation);
    }

    public function store(Request $request) {
        $user = User::find(Auth::user()->id);
        $guess = User::find($request->participant[0]['id']);
        $conversation = $user->getConversationWithUser($guess->id);
        if(!$conversation) {
            $conversation = Conversation::create([
                    'name' => $guess->name . "-" . Auth::user()->name                  
            ]);
            $conversation->participant()->attach([Auth::user()->id, $guess->id]);
        } 
        $conversation->message()->attach([1 => ['content' => $request->last_message]]);
        broadcast(new NewMessageEvent($conversation));
        return response()->json($conversation);
    }
}
