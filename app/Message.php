<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
//    public function sender()
//    {
//        return $this->belongsTo('App\User', 'sender_id');
//    }
    public function conversation()
    {
        return $this->belongsTo('App\Conversation', 'conversation_id');
    }
}
