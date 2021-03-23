<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $rules = [ 
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json([
            'user'        => $user,
            'access_token' => $accessToken
        ], 201);
    }

    public function login(Request $request){
        $rules = [
            'email' => "required|email",
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        if(!auth()->attempt($request->all())){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response()->json([
            'user'        => auth()->user(),
            'access_token' => $accessToken
        ], 200);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
