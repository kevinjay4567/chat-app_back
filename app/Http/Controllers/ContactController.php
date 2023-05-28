<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Http\Resources\FriendResource;
use App\Models\Contact;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

  use HttpResponses;

  public function addFriend(Request $request): JsonResponse
  {
    if (Auth::user()->id != $request->user && User::find($request->user)) {

      $contact = Contact::create([
        'user_id' => Auth::user()->id,
        'friend_id' => $request->user
      ]);

      return $this->success(new ContactResource($contact), 'Friend added', 200);
    }

    return $this->failed('', 'User not found', 404);
  }

  public function findUserFriends()
  {
    $contacts = Contact::where('user_id', Auth::user()->id)
      ->orWhere('friend_id', Auth::user()->id)->get();

    return response()->json(FriendResource::collection($contacts), 200);
  }
}
