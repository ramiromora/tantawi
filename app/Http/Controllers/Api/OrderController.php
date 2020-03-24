<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    //para generar las consultas externas con ajax
    public function store(Request $request){    
        
        $orden          = new Order;        
        $orden->order   = $request->order;        
        $orden->body    = $request->body;        
        $orden->act_id  = $request->act_id;        
        $orden->save();
        return $orden->id;
    }

    public function update(Request $request){        
        $orden = Order::find($request->id);    
        $orden->order   = $request->order;
        $orden->body    = $request->body;
        $orden->act_id  = $request->act_id;
        $orden->update();
        return $orden->id;
    }    


}
