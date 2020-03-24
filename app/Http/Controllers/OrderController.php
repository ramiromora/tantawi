<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Act;
use App\Committee;
use App\Company;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 

    public function show(Request $request){
        $act_id     = $request->input('act_id');
        $act = Act::find($act_id);
        $guests     = busca_guests($act_id);
        $users      = busca_users($act_id);        
        $principal  = busca_miembros($act->committee_id, $act->id);       
        $orders     = busca_orders($act_id);
        return view('orders.new',compact('act','users','guests','principal','orders'));
    }

    public function add(Request $request){
        ///recivimos datos
        $act_id         = $request->input('act_id');
        $orden          = new Order;
        $orden->order   = $request->input('order');
        $orden->body    = $request->input('body');
        $orden->act_id  = $act_id;
        $orden->save();
        $act = Act::find($act_id);
        //realizamos los arrays con datos anteriores
        $guests         = busca_guests($act_id);
        $users          = busca_users($act_id);
        $principal      = busca_miembros($act->committee_id, $act->id);
        $orders         = busca_orders($act_id);
        return view('orders.new',compact('act','users','guests','principal','orders'));
    }

    public function del(Request $request){
        $act_id     = $request->act_id;
        $id    = $request->id;
        $order = order::find($id)->delete();
        //realizamos los arrays con datos anteriores
        $act        = Act::find($act_id);
        $guests     = busca_guests($act_id);
        $users      = busca_users($act_id);
        $principal  = busca_miembros($act->committee_id, $act->id);
        $orders     = busca_orders($act_id);
        flash('Orden borrada exitosamente')->warning();
        return view('orders.new',compact('act','users','guests','principal','orders'));
    }




    public function vist(Request $request){
            ///recivimos datos 
        $act_id         =$request->input('act_id');
        $company_name   =$request->input('company_name');
        $title_or       =$request->input('title_or');
        $company_id     =$request->input('company_id');
        $date_or        =$request->input('date_or');

        $guests = DB::table('guests')
                ->join('act_guests', 'guests.id', '=', 'act_guests.guests_id')
                ->join('acts', 'acts.id', '=', 'act_guests.act_id')
                ->where('act_guests.act_id', '=', $act_id)
                ->select('guests.*')
                ->get();           

        $users  = DB::table('users')
                ->join('act_users', 'users.id', '=', 'act_users.user_id')
                ->join('acts', 'acts.id', '=', 'act_users.act_id')
                ->where('act_users.act_id', '=', $act_id)
                ->select('users.id','users.name')
                ->get();

        $orders =DB::table('orders')                
                ->where('act_id','=',$act_id)
                ->select('orders.*')
                ->get();

        return view('orders.vp2',compact('act_id','company_name' ,'date_or','title_or','users','guests','company_id','orders'));
    }
    
  
    public function edit2(Request $request) {        
        $id         = $request->id;              
        $act_id     = genera_id_ord($id);          
        $act        = Act::find($act_id);        
        $orders     = busca_orders($act_id);
        $orde       = Order::find($id);        
        $guests     = busca_guests($act_id);
        $users      = busca_users($act_id);        
        $principal  = busca_miembros($act->committee_id, $act->id);       
        $orders     = busca_orders($act_id);
        return view('orders.new2',compact('act','orders','orde','guests','users','principal', 'act'));
    }

   

    public function update2(Request $request){  
             
        $act_id         =$request->act_id;
        $id    = $request->input('id');       
        $order = Order::find($id);        
        $order->order   =$request->order;
        $order->body    =$request->body;
        $order->update();
        flash('La orden fue actualizada exitosamente')->success();
        //realizamos los arrays con datos anteriores
        $act        = Act::find($act_id);
        $guests     = busca_guests($act_id);
        $users      = busca_users($act_id);
        $principal  = busca_miembros($act->committee_id, $act->id);
        $orders     = busca_orders($act_id);
        return view('orders.new',compact('act','users','guests','orders','principal'));
      
    }

    public function back($act_id){
        $act        = Act::find($act_id);
        $guests     = busca_guests($act_id);
        $users      = busca_users($act_id);
        $principal  = busca_miembros($act->committee_id, $act_id);        
        $nousers    = userlist();
        return view('guests.new',compact('act','users','guests','principal','nousers'));
    }
    
    public function next(){
        
        $acts=DB::table('acts')->select('acts.*')->where('user_id','=', Auth()->user()->id)->orderBy('id', 'desc')->paginate(10); 
        
        return view('acts.list',compact('acts'));
    }

    public function pdf1($id){///BORRADOR

        $act = Act::find($id);
        $guests     = busca_guests($id);
        $users      = busca_users($id);
        $orders     = busca_orders($id);        
        $principal  = busca_miembros($act->committee_id, $act->id);
        $pdf = PDF::loadView('orders.vp2',compact('act','users','guests','orders','users','principal'));        
        return $pdf->download('acta_'.$id.'/'.date("Y", strtotime($act->date)).'_BORRADOR.pdf');
    }

    public function pdf2($id){// PDF DESPUES DE NOTIFICAR

        $act = Act::find($id);
        $guests     = busca_guests($id);
        $orders     = busca_orders($id); 
        $firmados   = busca_firmas($id);
        $pdf = PDF::loadView('orders.vp',compact('act','guests','orders','firmados'));        
        return $pdf->download('acta_'.$id.'/'.date("Y", strtotime($act->date)).'.pdf');
    }

    public function pdf3($id){///BORRADOR CON FIRMAS

        $act = Act::find($id);

        $guests     = busca_guests($id);
        $users      = busca_users($id);
        $orders     = busca_orders($id);        
        $principal  = busca_miembros($act->committee_id, $act->id);
        $pdf = PDF::loadView('orders.vp3',compact('act','users','guests','orders','users','principal'));
        
        return $pdf->download('acta_'.$id.'/'.date("Y", strtotime($act->date)).'_IMPRIMIR.pdf');
    }
    public function pdf4($id){// PDF DESPUES DE NOTIFICAR con firmas

        $act = Act::find($id);
        $guests     = busca_guests($id);
        $orders     = busca_orders($id); 
        $firmados   = busca_firmas($id);
        $pdf = PDF::loadView('orders.vpf',compact('act','guests','orders','firmados'));        
        return $pdf->download('acta_'.$id.'/'.date("Y", strtotime($act->date)).'.pdf');
    }


}
