<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
   protected $guarded = [];
   public function owner(){
       return $this->belongsTo('App\User', 'owner_id');
    }
    public function messages()
    {
        return $this->hasMany('App\Message', 'conversation_id');
    }
//    public function (){
//        return $this->hasOne('App\Conversation', 'parallel_id');
//    }

}
