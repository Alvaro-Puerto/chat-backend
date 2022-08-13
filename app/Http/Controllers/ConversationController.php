<?php

namespace App\Http\Controllers;

use App\Events\OnlineEvent;
use App\Events\UserOnlineEvent;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    //
    public function get($id) {
        $user = User::find(Auth::user()->id);
        $conversation = $user->conversation()->wherePivot('user_id', $id)->first();
        
        if(!$conversation) {
            $conversation = new Conversation();
            $conversation->name = 'Sin conversacion';
        }
        broadcast(new UserOnlineEvent());

        return response()->json($conversation);
    }

    public function create(Request $request) {

    }
}
