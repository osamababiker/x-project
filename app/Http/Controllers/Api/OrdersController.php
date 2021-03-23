<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Validator;

class OrdersController extends Controller
{
    public function getOrders(Request $request){
        $rules = [ 
            'user_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $orders = Order::where('is_deleted',0)->where('user_id',$request->user_id)->get();
        if(count($orders) == 0){
            return response()->json(['message' => 'there are no orders'],404);
        }
        return response()->json(['data' => $orders],200);
    }

    public function deleteOrder(Request $request){
        $rules = [ 
            'order_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $order = Order::find($request->order_id);
        if(!$order){
            return response()->json(['message' => 'no order match this id'], 404);
        }
        $order->is_deleted = 1;
        $order->save();
        return response()->json(['message' => 'order has been deleted'],200);
    }
}
