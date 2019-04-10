<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserPostRequest;
use App\User;

class AuthController extends Controller
{

   	public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = auth('api')->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

   	public function logout()
    {
        auth('api')->invalidate();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(UserPostRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);

        $token = auth('api')->login($user);
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => '60'
        ]);
    }

}
