<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User created',
            'token' => $user->createToken("API_TOKEN")->plainTextToken,
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'message' => 'Login successfuly',
                'token' => $user->createToken('API_TOKEN')->plainTextToken,
                'user' => $user
            ], 200);
        }

        return response()->json([
            'error' => 'Credentials dont match'
        ], 401);
    }

    public function profile()
    {
        return response()->json(Auth::user(), 200);
    }

    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout succesfuly'
        ], 200);
    }

}