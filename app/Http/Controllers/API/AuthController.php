<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use Validator;

class AuthController extends Controller 
{

    
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 500);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator], 422);
        }

        $user = User::where('email', $request->email)->first();
        if($user) {
            if(Hash::check($request->password, $user->password )) {
                #$token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;

                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'Por favor revise sus credenciales'], 500);
            }
        } else {
            return response()->json(['error' => 'Usuario no existe'], 500);
        }
    }
    
    public function logout(Request $request) {
        $request->user()->token()->revoke();

        return response()->json(["res" => "ok"], 200);
    }
}
?>