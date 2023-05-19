<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ContactController extends Controller
{

  public function index(): Response
  {
    $contacts = Contact::all();
    return Response($contacts, 200);
  }

  public function addFriend(Request $request, string $id): JsonResponse
  {
    if (strval($request->user) != $id && User::find($request->user)) {
    $contact = new Contact();
    $contact->user_contact = $request->user;
    $contact->user_id = $id;
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

  public function findUserFriends(string $id): Response
  {
    $contacts = Contact::where('user_id', $id)->get();

    return Response($contacts, 200);
  }
}
