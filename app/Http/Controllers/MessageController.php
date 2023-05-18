<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    //
  public function index(): Response
  {
    $messages = User::find(1)->message;
    return Response($messages, 200);
  }

  public function store(Request $request)
  {
    $message = new Message();
    $message->body = $request->body;
    $message->user_id = $request->user_id;
    $message->save();
    return response()->json([
      'message' => 'Message send'
    ], 201);
  }
}
