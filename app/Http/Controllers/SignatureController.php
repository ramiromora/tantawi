<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Act;
use App\Signature;
class SignatureController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function firmar(request $request){
        $act_id =$request->id;
        $act = Act::find($act_id);
        $user_id=Auth()->user()->id;
        $firm = buscanombre($user_id).$act->id;
        $fir = hash('ripemd160', $firm);
        $signature  = Signature::where('idU', auth()->user()->id)
                    ->where('act_id', $act_id)
                    ->update(['state' => 1, 'signature' => $fir]);
        $notifiationsC = list_x_comte(Auth()->user()->id);
        if(acta_firmada($act_id)){
            flash('El acta '.$act_id.'/'.date("Y", strtotime($act->date)).' fue aprobada por todos los participantes')->success();
            $act->state_id=4;
            $act->save();
        }
        flash('El Acta '.$act_id.'/'.date("Y", strtotime($act->date)).' fue firmada exitosamente')->success();
        return view('dashboard.index', compact('notifiationsC'));
    }

    public function rechasar(Request $request){
        $act_id = $request->id;
        $act = Act::find($act_id);
        $signature  = Signature::where('act_id', $act_id)
                    ->update(['state' => 0]);
        $act->state_id=3;
        $act->id_rech=Auth()->user()->id;
        $act->mod++;
        $act->save();
        $notifiationsC = list_x_comte(Auth()->user()->id);
        flash('El acta '.$act_id.'/'.date("Y", strtotime($act->date)).' fue rechazada y remitida a su Convocante')->error();
        return view('dashboard.index', compact('notifiationsC'));
    }
}
