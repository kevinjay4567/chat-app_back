<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

  use HttpResponses;

  public function register(UserRequest $request)
  {
    $request->validated($request->all());

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password)
    ]);

    return $this->success([
      'user' => $user,
      'token' => $user->createToken('API_TOKEN')->plainTextToken
    ], 'User created', 200);
  }

  public function login(LoginUserRequest $request)
  {
    $request->validated($request->only('email', 'password'));

    if (Auth::attempt($request->only('email', 'password'))) {

      $user = User::where('email', $request->email)->first();

      return $this->success([
        'user' => $user,
        'token' => $user->createToken('API_TOKEN')->plainTextToken
      ], 'Logged success', 200);
    }

    return $this->failed('', 'Credentials do not match', 401);
  }

  public function profile()
  {
    return $this->success(Auth::user(), '', 200);
  }

  public function logout()
  {

    Auth::user()->currentAccessToken()->delete();

    return $this->success('', 'Logout succesfully', 200);
  }
}
