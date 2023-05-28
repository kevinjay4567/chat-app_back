<?php

namespace App\Traits;

trait HttpResponses
{
  protected function success($data, $message = null, $code = 200)
  {
    return response()->json([
      'status' => 'OK',
      'message' => $message,
      'data' => $data
    ], $code);
  }

  protected function failed($data, $message = null, $code)
  {
    return response()->json([
      'status' => 'ERROR',
      'message' => $message,
      'data' => $data
    ], $code);
  }
}
