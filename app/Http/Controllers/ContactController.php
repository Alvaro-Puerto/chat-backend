<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    //
    public function get(Request $request) {
       $user = User::find(Auth::user()->id);
       $contacts = $user->contact;
        
       foreach($contacts as $item) {
           $item->active = false;
       }
       return response()->json($contacts);
    }

    public function detach($id) {
        $contact = User::find($id);
        
        $user = User::find(Auth::user()->id);

        $user->contact()->detach($contact);

        return response()->json($contact);
    }
}
