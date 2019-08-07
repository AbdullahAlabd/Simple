<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
//use App\http\ConversationController;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll(User $user)
    {
        return $user->orders;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_id'=>'required',
            'receiver_id' =>'required'
        ]);
        $order = new \App\Order($request->all());
        $order->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $order;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
    }
    public function accept(Order $order){
        $request = new Request();
        $request->owner_id = 32;
        $request->target_id = $order->receiver_id;

//        dd($request);
//        $this->destroy($order);
//        return redirect("/conversations")->with($request);
//        ConversationController::store($request);
//        return redirect('\conversations');
            return app()->call('App\http\Controllers\ConversationController@store', ['request'=>$request])       ;

    }

}
