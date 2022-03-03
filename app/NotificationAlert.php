<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class NotificationAlert extends Model
{
    //
    protected $table = 'notifications_messages';
    public $timestamps = true;


    public function scopeListMessage()
    {
      $ListMessage = NotificationAlert::where('receiver_id', Auth::user()->preferred_username)
                                      ->whereNull('seen')
                                      ->orderBy('id', 'DESC')
                                      ->limit(5)
                                      ->get();

      return $ListMessage;
    }


    public function scopeCountNewMessage($query, $preferred_username)
    {
      return $query->where('receiver_id', Auth::user()->preferred_username)
                   ->whereNull('seen')
                   ->get();
                // dd($aa);
    }


    public function scopeUpdateSeen($query,$id)
    {
      return $query->where('id',$preferred_username)->update(['seen' => 1]);
    }

}
