<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\User;

use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return void
     */
    public function showAll(User $user)
    {
        return $user->conversations;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $con_1 = new Conversation($request->all());
        $con_2 = new Conversation($request->all());

//        $con_1->owner_id = $request->owner_id;
//        $con_1->target_id = $request->target_id;
        $con_1->connected = true;
//
//        $con_2->owner_id = $request->owner_id;
//        $con_2->target_id = $request->target_id;
        $con_2->connected = true;

        $con_1->save();
        $con_2->save();

        $con_1->parallel_id =  $con_2->id;
        $con_2->parallel_id = $con_1->id;

        $con_1->save();
        $con_2->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        return $conversation;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Conversation $conversation)
    {
        $parallel = Conversation::find($conversation->parallel_id);

        $conversation->connected = !($conversation->connected) ;
        $parallel ->connected = !($parallel ->connected) ;

        $conversation->save();
        $parallel->save();
    }

}
