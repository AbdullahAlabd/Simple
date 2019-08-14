<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll(Conversation $conversation)
    {
        $messages = $conversation->messages->sortBy('created_at');
        return $messages;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Message
     */
    public function store(Request $request)
    {
//        $user = Auth::user();
        $user = User::find(1);
        $request->validate([
            'conversation_id'=>'required',
            'sender_id' =>'required',
            'content' =>'required',
        ]);
        $conversation = Conversation::find($request->conversation_id);
        $message_1 = new \App\Message($request->all());
        $message_2 = new \App\Message($request->all());
        $message_1->save();
        $message_2->conversation_id = $conversation->parallel_id;
        $message_2->save();
        broadcast(new MessageSent(User::find($conversation->target_id), $message_2))->toOthers();
        return  $message_1;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return $message;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
       return $message->delete();
    }
    public function default($id, $parallel_id)
    {

        $data = array(
            'conversation_id' => $id,
            'sender_id'=> 0,
            'content' => ' You are connected Say Hi :)',
        );
        $message_1 = new \App\Message($data);
        $message_2 = new \App\Message($data);
        $message_1->save();
        $message_2->conversation_id = $message_1->conversation->parallel_id;
        $message_2->save();
    }

}
