<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Resolution;
use App\Act;
use App\Company;
use App\Committee;
use App\Resolution_User;
class ResolutionController extends Controller
{
    public function new($id){

        $order_id   = $id;
        $date       = sacafecha(sacaacta($order_id));
        $users      = DB::table('users')
                    ->orderBy('name', 'ASC')
                    ->pluck('name','id');
        $nro        =cont_reso()+1;
        $correlativo=correlativo($nro);
        $tema       =sacatema($order_id);
        $desa       =sacadesa($order_id);
        $resolutions=sacareso($order_id);
        $respons    =sacaresp($order_id);
        return view('resolutions.new',compact('correlativo','order_id','users','date','tema','desa','resolutions','respons'));
    }

    public function store(request $request){
        $order_id       = $request->order_id;
        $reso           = new Resolution();
        $reso->id       = $request->id;
        $reso->order_id = $order_id;
        $reso->title    = $request->title;
        $reso->body     = $request->body;
        $reso->date     = $request->date;
        $reso->term     = $request->term;
        $reso->save();
        $reso_id       = $reso->id;
        ///parametros preenviados
        $date       = sacafecha(sacaacta($order_id));
        $users      = userlist();
        $nro        = cont_reso()+1;
        $correlativo= correlativo($nro);
        $tema       = sacatema($order_id);
        $desa       = sacadesa($order_id);
        $resolutions= sacareso($order_id);
        $respons    = sacaresp($order_id);
        flash('La resolución '.correlativo($reso_id).' fue agregada correctamente')->success();
        return view('resolutions.new',compact('correlativo','order_id','users','date','tema','desa','resolutions','respons'));
    }

    public function respoAdd(Request $request){
        $order_id   =$request->order_id;
        $user_id    =$request->user_id;
        $correlativo= $request->resolution_id;
        $relation = new Resolution_User;
        $relation->order_id = $order_id;
        $relation->user_id = $user_id;
        $relation->resolution_id = $correlativo;
        $relation->save();
        $date       = sacafecha(sacaacta($order_id));
        $users      = userlist();
        $nro        = cont_reso()+1;
        $correlativo= correlativo($nro);
        $tema       = sacatema($order_id);
        $desa       = sacadesa($order_id);
        $resolutions= sacareso($order_id);
        $respons    = sacaresp($order_id);
        flash('El responsable '.buscanombre($user_id).' fue agregado')->success();
        return view('resolutions.new',compact('correlativo','order_id','users','date','tema','desa','resolutions','respons'));
    }

    public function respoDel(Request $request){
        $order_id   =$request->order_id;
        $user_id    =$request->user_id;
        $correlativo= $request->resolution_id;
        $relation = Resolution_User::where('user_id',$user_id)->where('resolution_id',$correlativo)->delete();
        $date       = sacafecha(sacaacta($order_id));
        $users      = userlist();
        $nro        = cont_reso()+1;
        $correlativo= correlativo($nro);
        $tema       = sacatema($order_id);
        $desa       = sacadesa($order_id);
        $resolutions= sacareso($order_id);
        $respons    = sacaresp($order_id);
        flash('El responsable '.buscanombre($user_id).' fue borrado')->info();
        return view('resolutions.new',compact('correlativo','order_id','users','date','tema','desa','resolutions','respons'));
    }

    public function edit($id){

        $reso       = Resolution::find($id);
        $order_id   = $reso->order_id;
        $tema       = sacatema($order_id);
        $desa       = sacadesa($order_id);
        $correlativo= correlativo($reso->id);
        $order_id   = $reso->order_id;
        $date       = sacafecha(sacaacta($order_id));
        return view('resolutions.edit',compact('correlativo','reso','users','tema','desa','order_id','date'));
    }
    public function update(request $request){
        //ACTUALIZAR
        $reso = Resolution::find($request->id);
        $reso->title   = $request->title;
        $reso->body    = $request->body;
        $reso->term    = $request->term;
        $reso->save();
        $reso_id    = $reso->id;
        flash('Resolución '.correlativo($reso_id).' fue editada correctamente')->success();
        $id         = $request->order_id;
        $tema       = sacatema($id);
        $desa       = sacadesa($id);
        $correlativo= correlativo($reso->id);
        $users      = userlist();
        $order_id   = $reso->order_id;
        $date       = sacafecha(sacaacta($order_id));

        return view('resolutions.edit',compact('correlativo','reso','users','tema','desa','order_id','date'));
    }
    public function volver_edi($id){

        $order_id   = $id;
        $date       = sacafecha(sacaacta($order_id));
        $users      = userlist();
        $nro        = cont_reso()+1;
        $correlativo= correlativo($nro);
        $tema       = sacatema($order_id);
        $desa       = sacadesa($order_id);
        $resolutions= sacareso($order_id);
        $respons    = sacaresp($order_id);
        return view('resolutions.new',compact('correlativo','order_id','users','date','tema','desa','resolutions','respons'));
    }

    public function destroy($id){
        $reso = Resolution::find($id);
        $order_id   = $reso->order_id;
        $reso->delete();
        ordena_resolucion();       
        $date       = sacafecha(sacaacta($order_id));
        $users      = userlist();
        $nro        = cont_reso()+1;
        $correlativo= correlativo($nro);
        $tema       = sacatema($order_id);
        $desa       = sacadesa($order_id);
        $resolutions= sacareso($order_id);
        $respons    = sacaresp($order_id);
        return view('resolutions.new',compact('correlativo','order_id','users','date','tema','desa','resolutions','respons'));
    }

    public function ending($id){
        $act_id = sacaacta($id);
        $act = Act::find($act_id);
        $guests     = busca_guests($act_id);
        $users      = busca_users($act_id);
        $orders     = busca_orders($act_id);
        $principal  = busca_miembros($act->committee_id, $act->id);
        return view('orders.new',compact('act','users','guests','principal','orders'));
    }
    public function index(){
        return view('resolutions.index');
    }
}
