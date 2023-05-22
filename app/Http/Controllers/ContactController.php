<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

  public function index(): Response
  {
    $contacts = Contact::all();
    return Response($contacts, 200);
  }

  public function addFriend(Request $request): JsonResponse
  {
    if (Auth::user()->id != $request->user && User::find($request->user)) {

      $user = Auth::user();
      $friend = User::find($request->user);
      $contact = new Contact();
      $contact->user_id = $user->id;
      $contact->friend_id = $friend->id;
      $contact->user_name = $user->name;
      $contact->friend_name = $friend->name;
      $contact->save();

      return Response()->json([
        'message' => 'Friend add succesfuly'
      ], 200);

    } else {
      return Response()->json([
        'Error' => 'User not found'
      ], 404);
    }
  }

  public function findUserFriends()
  {
    $contacts = Contact::where('user_id', Auth::user()->id)
      ->orWhere('friend_id', Auth::user()->id)->get();

    return response()->json($contacts, 200);
  }

}