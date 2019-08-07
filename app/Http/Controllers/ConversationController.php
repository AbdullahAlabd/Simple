<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Http\Controllers\MessageController;
use App\Message;
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
        $sub = Message::select('conversation_id as con_id', \DB::raw('MAX(created_at) AS max_date'))
            ->groupBy('con_id');

        $sub = Message::join(\DB::raw("({$sub->toSql()}) max_table"), function($join)
        {
            $join->on('max_table.con_id', '=', 'messages.conversation_id')
            ->on('max_table.max_date', '=', 'messages.created_at');

        })->select('content', 'created_at', 'conversation_id', 'sender_id');
        $sub = Conversation::join(\DB::raw("({$sub->toSql()}) message_table"), function($join)
        {
            $join->on('message_table.conversation_id', '=', 'conversations.id');

        })->select('content', 'message_table.created_at', 'conversation_id', 'sender_id','conversations.target_id');
         $sub = User::join(\DB::raw("({$sub->toSql()}) conversation_table"), function($join)
         {
             $join->on('conversation_table.target_id', '=', 'id');

         })   ->select('name','content', 'conversation_table.created_at', 'conversation_id', 'sender_id','target_id')
         ->addBinding($sub->getBindings(),'join');

//        $sub = \DB::raw(
//            '(SELECT * MAX(created_at) As `max_date`
//               FROM messages
//               GROUP BY conversation_id) max_table
//            ');
//
//        $conversations = Message::select('conversation_id',\DB::raw('MAX(messages.created_at) AS created_at'))
//            ->groupby('conversation_id')
////            ->join('conversations', 'messages.conversation_id', '=', 'conversations.id')
//            ->orderBy('created_at', 'desc');
//        $conversations = \DB::table('messages')->select(\DB::raw("*  FROM messages where row(conversation_id, created_at) in (SELECT conversation_id, MAX(created_at) AS created_at FROM messages group by conversation_id ) order by created_at")) ->get();
//    dd($sub->get());
        return $sub->get();
//        return $user->conversations->sortBy('created_at');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'owner_id'=>'required',
//            'target_id' =>'required',
//        ]);
//        $connected = Conversation::where(['owner_id' => $request->owner_id, 'target_id' => $request->target_id]);
//        dd($request->owner_id);
        $connected = \DB::table('conversations')->where([['owner_id' ,'=' ,$request->owner_id], ['target_id', '=', $request->target_id]])->get();
//        return(empty($connected ) );
//        return count($connected );
        if(count($connected ) == 0){
            $con_1 = new Conversation();
            $con_2 = new Conversation();

            $con_1->owner_id = $request->owner_id;
            $con_1->target_id = $request->target_id;
            $con_1->connected = true;

            $con_2->owner_id = $request->target_id;
            $con_2->target_id = $request->owner_id;
            $con_2->connected = true;

            $con_1->save();
            $con_2->save();

            $con_1->parallel_id =  $con_2->id;
            $con_2->parallel_id = $con_1->id;

            $con_1->save();
            $con_2->save();

            $messageC = new MessageController();
            $messageC->default($con_1->id, $con_2->id);
        }
        else{
            return response('This connection exist', 303);
        }
//        $con_1 = new Conversation($request->all());
//        $con_2 = new Conversation($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        return redirect("/messages/showAll/$conversation->id");
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
