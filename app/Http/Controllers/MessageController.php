<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
  //
  public function index(): Response
  {
    $messages = Message::all();
    return Response($messages, 200);
  }

  public function store(Request $request)
  {
    if (User::find($request->user_receive)) {
      $message = new Message();
      $message->body = $request->body;
      $message->user_id = Auth::user()->id;
      $message->name_send = Auth::user()->name;
      $message->user_receive = $request->user_receive;
      $message->save();
      return response()->json([
        'message' => 'Message send'
      ], 201);
    }

    return response()->json([
      'error' => 'User not found'
    ], 404);

  }

  public function findMessageByUser(string $id): Response
  {
    $userMessage = User::find($id)->messages;
    return Response($userMessage, 200);
  }

  public function sendMessage(Request $request)
  {
    event(new SendMessageEvent($request->body, Auth::user()->name, $request->user_receive));
    $this->store($request);
    return response()->json([
      'message' => 'Broadcast'
    ], 200);
  }

}