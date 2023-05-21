<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory;

  protected $fillable = [
    'body',
    'user_id',
    'user_receive',
    'name_send'
  ];

  public function user(): HasOne
  {
    return $this->hasOne(User::class);
  }
}
