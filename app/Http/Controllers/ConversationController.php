<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    //
    public function get($id) {
        $conversation = Conversation::query()->participant()
            ->wherePivotIn('user_id', [$id])->get();

        return response()->json($conversation);
    }

    public function create(Request $request) {

    }
}
