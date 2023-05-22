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
    }

  }

  public function findMessageWithFriend(Request $request)
  {
    $user_req = Auth::user()->id; // ID del usuario X
    $user_res = $request->friend; // ID del usuario Y

    $messages = Message::where(function ($query) use ($user_req, $user_res) {
      $query->where('user_id', $user_req)
        ->where('user_receive', $user_res);
    })->orWhere(function ($query) use ($user_req, $user_res) {
      $query->where('user_id', $user_res)
        ->where('user_receive', $user_req);
    })->get();

    return response()->json($messages, 200);
  }

  public function sendMessage(Request $request)
  {
    if (User::find($request)) {
      event(new SendMessageEvent($request->body, Auth::user()->id, Auth::user()->name, $request->user_receive));
      $this->store($request);
      return response()->json([
        'message' => 'Message send'
      ], 200);
    }

    return response()->json([
      'error' => 'User not found'
    ], 200);
  }

}