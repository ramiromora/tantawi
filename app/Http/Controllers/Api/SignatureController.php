<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Signature;
use App\Act;


class SignatureController extends Controller
{

    public function firmar($user_id,$act_id,$token){
        $act = Act::find($act_id);
        $firm = buscanombre($user_id).$act->id;
        $fir = hash('ripemd160', $firm);
        if($token==$fir){
            $signa  = Signature::where('idU', $user_id)
                    ->where('act_id', $act_id)->first();
            if(is_null($signa->signature)){
                $signature  = Signature::where('idU', $user_id)
                ->where('act_id', $act_id)
                ->update(['state' => 1, 'signature' => $fir]);
                if(acta_firmada($act_id)){
                            $act->state_id=4;
                            $act->save();
                }
                $firm = buscanombre($user_id).$act->id;
                $fir = hash('ripemd160', $firm);
                $men = 'Acta <b>"'.$act->title.'" Nro'.$act->correlative.'/'.date("Y", strtotime($act->date)).'</b> firmado correctamente por:<i>'.buscanombre($user_id).'</i> <br>Firma --'.$fir.' ir a <a href="http://tantawi.ofep.gob.bo">Sistema Tantawi</a>';
                return $men;
            }else{
                return ('Usted ya firmo esta acta');
            }
        }else{
            return 'Error al firmar acta ';
        }
    }
}
