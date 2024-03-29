<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): Response
  {
    //
    $users = User::all();
    return Response($users, 200);
  }

  /**
   * Show the form for creating a new resource.
   */
  /*     public function create(): Response
    {
        //
    } */

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->save();
    return response()->json([
      'message' => 'User created successfully'
    ], 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id): Response
  {
    //
    $user = User::find($id);
    return Response($user, 200);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id): Response
  {
    //
    $user = User::find($id);
    return Response($user, 200);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
    $user = User::find($id);
    $user->update($request->all());
    return response()->json([
      'message' => 'User updated successfully'
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
    $user = User::find($id);
    $user->delete();
    return response()->json([
      'message' => 'User deleted successfully'
    ], 200);
  }
}
