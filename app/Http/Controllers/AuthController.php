<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request){

        if(User::where('email',$request->email)->first()){
            return ["message" => "Email already register"];
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = $user->createToken('mytoken')->plainTextToken;
        $reponse = ["token" => $token, 'message' => 'ok'];

        return $reponse;
    }

    public function logout(Request $request){
        if(!$request->user() || !$request->user()->tokens()){
            return ["massage" => "invalid token"];
        }

        $request->user()->tokens()->delete();
        return ["massage" => "ok"];
    }

    public function user(Request $request) {
         return $request->user();
    }

    public function changePassword(Request $request){

        if (!Hash::check($request->password, $request->user()->password)) {
            return ["massage" => 'Login wrong password'];
        }

        $request->user()->password = $request->password;

        $token = $request->user()->createToken('mytoken')->plainTextToken;
        $response = ["massage" => 'Login wrong password',"token" => $token];
        return response($response,501);
    }

    public function login(Request $request){
        $user = User::where('email',$request->email)->first();

        if (!$user){
            return ['message' => 'Login wrong email'];
        }
        if (!Hash::check($request->password, $user->password)) {
            return ['message' => 'Login wrong password'];
        }

        $token = $user->createToken('mytoken')->plainTextToken;
        $reponse = ["name" => $user->name, "token" => $token, 'message' => 'ok'];

        return $reponse;
    }

}
