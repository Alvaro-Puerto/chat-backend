<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function search(string $name) {
        $users = User::where('name', 'LIKE', '%'.$name.'%')->get();
        return response()->json($users);
    }

    public function addContact(Request $request, int $user_id) {
        $user = User::find(Auth::user()->id);
        $user->contact()->attach($user_id);
        $user_guess = User::find($user_id);
        return response()->json($user_guess, 200);
    }
}
