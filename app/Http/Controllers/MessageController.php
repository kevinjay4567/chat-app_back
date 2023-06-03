<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

  use HttpResponses;

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

    return response()->json(MessageResource::collection($messages), 200);
  }

  public function sendMessage(Request $request)
  {
    if (User::find($request->user_receive) && Auth::user()->id !== $request->user_receive) {
      event(new SendMessageEvent($request->body, Auth::user()->id, Auth::user()->name, $request->user_receive));
      $message = Message::created([
        'body' => $request->body,
        'user_id' => Auth::user()->id,
        'user_receive' => $request->user_receive
      ]);

      return $this->success($message, 'Message send', 200);
    }

    return $this->failed('', 'User not found', 401);
  }
}
