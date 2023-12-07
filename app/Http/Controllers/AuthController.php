<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function checkUsername(UserRequest $request){
        $registered = 'no';

        if(User::where(['name' => $request->username])->first()){
            $registered = 'yes';
        }

        return $registered;
    }
    public function login(UserRequest $request){
        if(Auth::attempt(['name' => $request->username, 'password'=> $request->password], true)){
            $user = Auth::user();
            $response = [
                'success' => true,
                'token' => $user->createToken('thedaywhen')->plainTextToken
            ];
            
            return response()->json($response,200);
        }
        else {
            $response = [
                'success' => false,
                'token' => false
            ];
            return response()->json($response,200);
        }
    }
    public function register(UserRequest $request){
        $user = User::create(['name' => $request->username, 'password' => bcrypt($request->password)]);

        if(Auth::attempt(['name' => $request->username, 'password'=> $request->password], true)){
            $response = [
                'success' => true,
                'token' => $user->createToken('thedaywhen')->plainTextToken
            ];
            
            return response()->json($response,200);
        }
        else {
            $response = [
                'success' => false,
                'token' => false
            ];
            return response()->json($response,200);
        }
    }
    public function logout(){
        Auth::logout();
        unset($_COOKIE['XSRF-TOKEN']);
    }
}