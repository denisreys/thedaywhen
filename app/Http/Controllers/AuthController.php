<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function checkUsername(UserRequest $request){
        if(User::where(['name' => $request->username])->first()) return true;
        else return false;
    }
    public function login(UserRequest $request){
        if($this->tryingAttempt($request->username, $request->password)){
            $user = Auth::user();
            $token = $user->createToken('thedaywhen')->plainTextToken;

            return $this->authResult(true, $token);
        }else {
            return $this->authResult(false, false);
        }
    }
    public function register(UserRequest $request){
        $user = User::create(['name' => $request->username, 'password' => bcrypt($request->password)]);
        
        if($this->tryingAttempt($request->username, $request->password)){
            $user = Auth::user();
            $token = $user->createToken('thedaywhen')->plainTextToken;

            return $this->authResult(true, $token);
        }else {
            return $this->authResult(false, false);
        }
    }
    private function tryingAttempt($username, $password){
        return Auth::attempt([
            'name' => $username, 
            'password'=> $password
        ], true);
    }
    private function authResult($success, $token){
        $response = [
            'success' => $success,
            'token' => $token
        ];

        return response()->json($response, 200);
    }
    public function logout(){
        Auth::logout();
        unset($_COOKIE['XSRF-TOKEN']);
    }
}