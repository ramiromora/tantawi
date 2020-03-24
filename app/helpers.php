<?php




use Illuminate\Support\Facades\DB;
use App\Signature;
use App\Committee;
use App\Act_Committee;
use App\Committee_User;
use App\Act;
use App\User;
use App\Order;
use App\Company;
use App\Resolution;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

///para realizar la consulta personalizada
// function runer(){
//     Permission::create(['name' => 'create.role']);
//     Permission::create(['name' => 'read.role']);
//     Permission::create(['name' => 'edit.role']);
//     Permission::create(['name' => 'delete.role']);
//     Permission::create(['name' => 'create.permission']);
//     Permission::create(['name' => 'read.permission']);
//     Permission::create(['name' => 'edit.permission']);
//     Permission::create(['name' => 'delete.permission']);

//     $admin = Role::create(['name' => 'Admin']);
//     $admin->givePermissionTo(Permission::all());
//     $user = User::find(1); //Jorge Rios
//     $user->assignRole('Admin');
// }


function hola_mundo($user_id){
    $user = User::find($user_id);
    return 'Saludos: '.$user->name;
}


function parametrica_get($group){
    return App\Parametric::where('group',$group);
}

function currentUser()
{
    return auth()->user();
}
//funciones en las que podemos llamar desde diferentes lados uso en el controlador ActController
function obtenerFechaEnLetra($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $dia.' '.$num.' de '.$mes.' del '.$anno;
}

function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}
function sacafecha($act_id){
    $act = Act::find($act_id);
    $date= $act->date;
    return $date;
}
function datosacta($act_id){
    $acta = Act::find($act_id);
    return $acta;
}
function sacaacta($order_id){
    $ord = Order::find($order_id);
    $act_id= $ord->act_id;
    return $act_id;
}
function sacareso($order_id){
    $resolutions    = DB::table('resolution')
                    ->where('order_id','=',$order_id)
                    ->select('id','title')
                    ->orderBy('id','DSC')
                    ->get();
    return  $resolutions;
}
function cont_reso(){
    $canti  = DB::table('resolution')
            ->select('resolution.id')
            ->max('id');
    return $canti;
}
function userlist(){
    $users      = DB::table('users')
                ->orderBy('name', 'ASC')
                ->pluck('name','id');
    return $users;
}


function correlativo($int){
    $correlativo='';
    $lon=strlen($int);
    if($lon==1){
        $correlativo='000'.$int;
    }elseif($lon==2){
        $correlativo='00'.$int;
    }elseif($lon==3){
        $correlativo='0'.$int;
    }elseif($lon==4){
        $correlativo=''.$int;
    }
    return $correlativo;
}
function sacatema($order_id){
    $orden = Order::find($order_id);
    $tema= $orden->order;
    return $tema;
}
function sacadesa($order_id){
    $orden = Order::find($order_id);
    $desa= $orden->body;
    return $desa;
}
///para sacar los id de los 3 miembros principales del comite
function sacaid1($principal){
    $b=0;
    foreach($principal as $princi){
        if($b==0)
        {
            $id = $princi->id;
        }
        $b++;
    }
    return $id;
}

function sacaid2($principal){
    $b=0;
    foreach($principal as $princi){
        if($b==1)
        {
            $id = $princi->id;
        }
        $b++;
    }
    return $id;
}

function sacaid3($principal){
    $b=0;
    foreach($principal as $princi){
        if($b==2)
        {
            $id = $princi->id;
        }
        $b++;
    }
    return $id;
}
function cuenta_reso($order_id){
    $canti  = DB::table('resolution')
            ->select(DB::raw('count(*) as counteo'))
            ->where('order_id','=', $order_id)
            ->first();
    $cantidad = $canti->counteo;
    return $cantidad;
}


function saca_reso($order_id){
    $resolutions = DB::table('resolution')
    ->select('id','title','body','term')
    ->where('order_id','=',$order_id)
    ->get();
    return $resolutions;
}
function sacaresp($order_id){
    $respons    = DB::table('resolution_users')
                ->select('user_id','resolution_id','order_id')
                ->where('order_id','=',$order_id)
                ->get();
    return $respons;
}
function cuenta_reso_t($act_id){
    $canti  = DB::table('resolution')
            ->join('orders','orders.id','=','resolution.order_id')
            ->join('acts','acts.id','=','orders.act_id')
            ->where('acts.id','=', $act_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $canti->counteo;
    return $cantidad;
}
function buscaresponsables($resolution_id){
    $respons    = DB::table('resolution_users')
                ->select('user_id')
                ->where('resolution_id','=',$resolution_id)
                ->get();
    return $respons;
}
//averiguar como funciona el envio de arrays
function capsulador($act_id,$company_name,$date_or,$title_or,$company_id,$committee_name,$name_respo,$time_or){

    $datas = array(
        'act_id'        => $act_id,
        'company_name'  => $company_name,
        'date_or'       => $date_or,
        'title_or'      => $title_or,
        'company_id'    => $company_id,
        'committee_name'=> $committee_name,
        'name_respo'    => $name_respo,
        'time_or'       => $time_or
    );
    return $datas;
}

function consulta_comite($id){
    $committee_id   = DB::table('committee')
                    ->join('committee_users', 'committee.id', '=', 'committee_users.committee_id')
                    ->where('committee_users.user_id', '=', $id)
                    ->select('committee.id')
                    ->first();
    return $committee_id;
    //haberiguar funcionalidad de las funciones
}

function list_x_user($id){
    $est=2;
    $notifi = DB::table('acts')
            ->join('users', 'users.id','=','acts.user_id')
            ->join('act_users', 'act_users.act_id','=','acts.id')
            ->where('act_users.user_id','=',$id)
            ->where('acts.state_id','>=',$est)
            ->select('acts.id','acts.title','users.name','acts.state_id')
            ->orderby('acts.id', 'DSC')
            ->paginate(10);
    //consulta a partir de
    //select a.id, a.title , b.name from acts a inner join users b join act_users c where c.act_id = a.id and c.user_id = 2 and a.state_id = 2 and b.id = a.user_id
    return $notifi;

}
function genera_id_ord($order_id){
 $orden = Order::find($order_id);
 $act_id = $orden->act_id;
 return $act_id;
}
function list_x_comte($id){
    $est=2;
    $notifi = DB::table('acts')
            ->join('users', 'users.id','=','acts.user_id')
            ->join('signatures', 'signatures.act_id','=','acts.id')
            ->where('signatures.idu','=',$id)
            ->where('acts.state_id','>=',$est)
            ->select('signatures.act_id','acts.title','acts.date','users.name','acts.state_id','signatures.state','acts.id_rech')
            ->orderby('signatures.act_id', 'DSC')
            ->paginate(10);

    //consulta a partir de
    //select a.id, a.title , b.name from acts a inner join users b where a.committee_id =1 and a.state_id = 2 and b.id = a.user_i
    return $notifi;
}
/////********************  Estoy desde aqui */
function gen_carg($id){
    $descr=DB::table('users')
            ->select('users.description')
            ->where('id','=',$id)
            ->first();

    $cargo=$descr->description;
    return $cargo;
}

function estoy_en_comite($comtie_id,$user_id){
    $canti  = DB::table('committee_users')
            ->where('user_id','=', $user_id)
            ->where('committee_id','=',$comtie_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    if($canti->counteo>0){
        return true;
    }else{
        return false;
    }
}

function estoy_en_miembros($act_id,$user_id){

    $canti  = DB::table('act_committees')
            ->where('user_id','=', $user_id)
            ->where('act_id','=',$act_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    if($canti->counteo>0){
        return true;
    }else{
        return false;
    }
}

function soy_miembro_principal($act_id,$user_id,$comtie_id){
    $canti  = DB::table('act_committees')
            ->where('act_id','=', $act_id)
            ->where('user_id','=', $user_id)
            ->where('committee_id','=',$comtie_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    if($canti->counteo>0){
        return true;
    }else{
        return false;
    }
}

function gen_user($id){
    $descr=DB::table('users')
            ->select('users.*')
            ->where('id','=',$id)
            ->first();
    return $descr;
}
function list_x_comte_com($id){///aqui verificamos de que los actas listados sean solos los que estan en estado 4 para q los lleven a estado 5 o se queden en 4

    $est=4;
    $notifi = DB::table('acts')
            ->join('users', 'users.id','=','acts.user_id')
            ->join('signatures', 'signatures.act_id','=','acts.id')
            ->where('signatures.idU','=',$id)
            ->where('acts.state_id','>=',$est)
            ->select('signatures.act_id','acts.title','users.name','acts.state_id','signatures.state')
            ->orderby('signatures.act_id', 'DSC')
            ->paginate(12);

    //consulta a partir de
    //select a.id, a.title , b.name from acts a inner join users b where a.committee_id =1 and a.state_id = 2 and b.id = a.user_i
    return $notifi;
}
function actas_firmadas(){
    $notifi = DB::table('acts')
            ->join('users', 'users.id','=','acts.user_id')
            ->where('acts.state_id','>',3)
            ->select('acts.id','acts.title','users.name','acts.state_id','users.departament_id','acts.pdf','acts.id_rech','acts.mod','acts.date')
            ->orderby('acts.id', 'DSC')
            ->paginate(10);
    return $notifi;
}
function actas_firmadas_raw(){
    $notifi = DB::table('acts')
            ->join('users', 'users.id','=','acts.user_id')
            ->where('acts.state_id','>',3)
            ->select('acts.id','acts.title','users.name','acts.state_id','users.departament_id','acts.pdf','acts.id_rech','acts.mod','acts.date')
            ->orderby('acts.id', 'DSC')
            ->get();
    return $notifi;
}
function buscar_responsables_2($user_id,$departament_id){
    $data   = DB::table('users')
            ->where('departament_id','=',$departament_id)
            ->where('id','<>',$user_id)
            ->pluck('name','id');
    return $data;
}
function busca_cantidad_resp($user_id,$comt_id){
$canti   = DB::table('committee_users')
            ->where('user_id', $user_id)
            ->where('committee_id', $comt_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $canti->counteo;
return $cantidad;
}
function conoser_responsable($user_id){
    $dato   = DB::table('users')
            ->select('name','description')
            ->where('replace','=',$user_id)
            ->first();
    return  $dato;
}
function buscar_responsables_3($user_id){
    $data   = DB::table('users')
            ->where('id','<>',$user_id)
            ->where('level','=',2)
            ->pluck('name','id');
    return $data;
}
function lista_comites(){
    $comites = Committee::orderby('id')->get();
    return $comites;
}

function buscanombre($id){
    $data   = DB::table('users')
            ->select('name')
            ->where('id','=',$id)
            ->first();
    $name =$data->name;

    return $name;
}


function buscanombrerech($act_id){
    $rech_id    = DB::table('acts')
                ->select('id_rech')
                ->where('id','=',$act_id)
                ->first();

    $name =buscanombre($rech_id->id_rech);

    return $name;
}
function buscadep($departamento){
    $tex='';
if($departamento==1){
    $tex='Unidad de Gestion de Información';
}elseif($departamento==2){
    $tex='Dirección de Análisis de Gestión Empresarial y Tecnológica';
}elseif($departamento==3){
    $tex='Unidad Administrativa Financiera';
}elseif($departamento==4){
    $tex='Dirección General Ejecutiva';
}elseif($departamento==5){
    $tex='Dirección de Análisis Jurídico';
}
return $tex;
}
function buscadepS($departamento){
    $tex='';
if($departamento==1){
    $tex='UGI';
}elseif($departamento==2){
    $tex='DAGET';
}elseif($departamento==3){
    $tex='UAF';
}elseif($departamento==4){
    $tex='DGE';
}elseif($departamento==5){
    $tex='DAJ';
}
return $tex;
}
function buscacargo($id){
    $data   = DB::table('users')
            ->select('description')
            ->where('id','=',$id)
            ->first();
    $name =$data->description;

    return $name;
}
function buscadescri($id){
    $data   = DB::table('users')
            ->select('description')
            ->where('id','=',$id)
            ->first();
    $descri =$data->description;

    return $descri;
}
function contar_in($act_id){
    $invi   = DB::table('act_users')
            ->where('act_id', $act_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $invi->counteo;
return $cantidad;
}

function cuenta_firmas($act_id){
    $firmas   = DB::table('signatures')
            ->where('act_id', $act_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $firmas->counteo;
    return $cantidad;
}

function contar_remp($id){
    $num = 0;
    $comites = Committee::all();
    foreach($comites as $comite){
        $idcom=$comite->id;///obtenemos el id del comite
        $comi = DB::table('committee_users')
                ->where('committee_id','=',$idcom)
                ->where('user_id','=',$id)
                ->select('id','committee_id','user_id')
                ->get();
        $b=0;
        foreach($comi as $com){
            if($com->user_id==$id){
                $b++;
            }
            if($b==2){
                $num++;
            }
        }
    }
    return $num;
}
function buscaordenes($user_id){
    $mencion=DB::table('resolution_users')
                ->where('user_id','=',$user_id)
                ->select('order_id')
                ->get();
    return $mencion;
}
function busca_doble_remplaza($id,$idr){////////////////////////////////////////////////funcion requisito uno
    $comites = Committee::all();
    foreach($comites as $comite){
        $idcom=$comite->id;///obtenemos el id del comite
        $comi = DB::table('committee_users')
                ->where('committee_id','=',$idcom)
                ->where('user_id','=',$id)
                ->select('id','committee_id','user_id')
                ->get();
        $b=0;
        foreach($comi as $com){

            if($com->user_id==$id){
                $b++;
            }
            if($b==2){
                ///remplazamos si es doble
                $rempla = Committee_User::where('id', $com->id)
                        ->update(['user_id' => $idr]);
                ///generamos un sumador de cambios
                $comit = Committee::find($idcom);
                $comit->changes = 2;
                $comit->save();
                ///
            }
        }
    }
}

function contar_ex($act_id){
    $invi   = DB::table('act_guests')
            ->where('act_id', $act_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $invi->counteo;
    return $cantidad;
}
function contar_fir($act_id){
    $inter = contar_in($act_id);
    $exter = contar_ex($act_id);
    $total = $inter +$exter;
    return $total;
}
function contar_met($act_id){
    $act = Act::find($act_id);
    $total = $act->quantity;
    return $total;
}
function contar_act($act_id){
    $firm   = DB::table('signatures')
            ->where('act_id', $act_id)
            ->where('state', 1)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $firm->counteo;
return $cantidad;
}
function busca_users($act_id){
    $users  = DB::table('users')
            ->join('act_users', 'users.id', '=', 'act_users.user_id')
            ->join('acts', 'acts.id', '=', 'act_users.act_id')
            ->where('act_users.act_id', '=', $act_id)
            ->select('users.id', 'users.name','users.description')
            ->get();
    return $users;
}
function busca_guests($act_id){
    $guests = DB::table('guests')
            ->join('act_guest', 'guests.id', '=', 'act_guest.guest_id')
            ->join('acts', 'acts.id', '=', 'act_guest.act_id')
            ->where('act_guest.act_id', '=', $act_id)
            ->get();
    return $guests;
}
function contador_guest_ins($act_id){
    $act = Act::find($act_id);
    $invi   = DB::table('guests')
            ->join('act_guest', 'guests.id', '=', 'act_guest.guest_id')
            ->join('acts', 'acts.id', '=', 'act_guest.act_id')////ver como podemos saver la cantidad de invitados externos
            ->where('guests.company_id','=',$act->company_id)
            ->where('act_guest.act_id', '=', $act_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $invi->counteo;
    return $cantidad;
}

function busca_comite($comite_id){//////////////////////////////////////////////////////////////////////////////////////////--------- aqui colocaremos la nueva funcion con la nueva tabla
    $principal  = DB::table('users')
                ->join('committee_users', 'users.id', '=', 'committee_users.user_id')
                ->where('committee_users.committee_id','=',$comite_id)
                ->select('users.id','users.name','users.description')
                ->orderBy('users.name', 'ASC')
                ->get();
    return $principal;
    if (true) {
        return null;
    } else {
        return 1;
    }
    
}
function genera_miembros($act_id){
    $act = Act::find($act_id);
    $comite_id = $act->committee_id;
    $members = DB::table('users')
                ->join('act_committees', 'users.id', '=', 'act_committees.user_id')
                ->where('committee_id','=',$comite_id)
                ->where('act_id','=',$act_id)
                ->orderBy('users.id', 'ASC')
                ->pluck('users.id');
    return $members;
}
function busca_miembros($comite_id,$act_id){
    $members = DB::table('users')
                ->join('act_committees', 'users.id', '=', 'act_committees.user_id')
                ->where('committee_id','=',$comite_id)
                ->where('act_id','=',$act_id)
                ->select('users.id','users.name','users.description')
                ->orderBy('users.name', 'ASC')
                ->get();
    return $members;
}

function busca_comite_yo($comite_id,$user_id){
    $principal  = DB::table('users')
                ->join('committee_users', 'users.id', '=', 'committee_users.user_id')
                ->where('committee_users.committee_id','=',$comite_id)
                ->where('committee_users.user_id','<>',$user_id)
                ->select('users.id','users.name','users.description')
                ->get();
    return $principal;
}

function busca_miembro_yo($comite_id,$user_id){
    $principal  = DB::table('users')
                ->join('act_committees', 'users.id', '=', 'act_committees.user_id')
                ->where('act_committees.committee_id','=',$comite_id)
                ->where('act_committees.user_id','<>',$user_id)
                ->select('users.id','users.name','users.description')
                ->get();
    return $principal;
}

function busca_orders($act_id){
$orders = DB::table('orders')
        ->select('orders.id','orders.order','orders.body')
        ->where('act_id','=',$act_id)
        ->get();
        return $orders;
}
function busca_firmas($act_id){
    $firmados   = DB::table('signatures')
                ->where('signatures.act_id', '=', $act_id)
                ->select('signatures.*')
                ->get();
    return $firmados;
}
function comite_list(){
    $comites =  Committee::all();
    return $comites;
}
function busca_id_com_fir($act_id){///usarios invidatos del comite
    $com_fir  = DB::table('signatures')
            ->where('signatures.act_id','=',$act_id)
            ->where('signatures.tipe','=',1)
            ->select('signatures.idU')
            ->get();
    return $com_fir;
}

function busca_id_fir($act_id){
    $firm_id  = DB::table('signatures')
            ->where('signatures.act_id','=',$act_id)
            ->select('signatures.idU')
            ->get();
    return $firm_id;
}

function busca_id_act($act_id){///usarios invidatos
    $acts_id  = DB::table('act_users')
            ->where('act_users.act_id','=',$act_id)
            ->select('act_users.user_id')
            ->get();
    return $acts_id;
}
function estoy_seteado_como_unico($act_id){
    $act = Act::find($act_id);
    $invi   = DB::table('act_committees')
            ->where('act_id','=',$act->id)
            ->where('committee_id','=',$act->committee_id)
            ->where('user_id','=', $act->user_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $invi2   = DB::table('act_committees')
            ->where('act_id','=',$act->id)
            ->where('committee_id','=',$act->committee_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $invi->counteo;
    $cantidad2 = $invi2->counteo;
    if($cantidad==1&&$cantidad2==1){
        return true;
    }else{
        return false;
    }
}
function cuenta_miembros($act_id){
    $act    = Act::find($act_id);
    $invi2  = DB::table('act_committees')
                ->where('act_id','=',$act->id)
                ->where('committee_id','=',$act->committee_id)
                ->select(DB::raw('count(*) as counteo'))
                ->first();
    $cantidad2 = $invi2->counteo;
    return $cantidad2;
}

function busca_agrega_mem_rempla($act_id,$miembros_n){
    $act = Act::find($act_id);
    $miembros_a = busca_miembros($act->committee_id, $act->id);
    $num_miembros = count($miembros_n);
    $cambios = 0;

    ////algoritmo para busca si no encuentra agrega
        for($i = 0 ; $i<$num_miembros; $i++){
            $id_miembro_n = $miembros_n[$i];
            $ba = true;
            foreach($miembros_a as $miembro_a){
                $id_miembro_a = $miembro_a->id;
                if($id_miembro_a == $id_miembro_n && $ba){
                    $ba = false;
                }
            }
            if($ba){
                $membe = new Act_Committee;
                $membe->act_id = $act->id;
                $membe->committee_id = $act->committee_id;
                $membe->user_id = $miembros_n[$i];
                $membe->save();
                $cambios++;
            }
        }
    ////fin algoritmo que agrega
    /// algoritmo busca si no encuentra elimina
        foreach ($miembros_a as $miembro_an) {
            $id_miembro_an = $miembro_an->id;
            $b = true;
            for($i = 0; $i<$num_miembros ; $i++){
                $id_miembro_n = $miembros_n[$i];
                if($id_miembro_n == $id_miembro_an && $b){
                    $b = false;
                }
            }
            if($b){
                $membe = Act_Committee::where('act_id',$act->id)->where('committee_id',$act->committee_id)->where('user_id', $id_miembro_an)->delete();
                $cambios++;
            }
        }
    //// fin algoritmo que elimina
    return $cambios;
}

function busca_id_add($act_id){
    $cade = ' Agregados :';
    $acts_id = busca_id_act($act_id);///primero con los invitados internos
    $firm_id = busca_id_fir($act_id);

    foreach($acts_id as $a_u_id){
        $b = false;
        $id_u = $a_u_id->user_id;
        foreach($firm_id as $f_u_id){
            $id_uf = $f_u_id->idU;
            if($id_u==$id_uf&&$b==false){ ///comparamos si son iguales
                $b=true;
            }
        }
        if(!$b){
            $nom        = buscanombre($id_u);
            $car        = buscadescri($id_u);
            $signature  = new Signature;
            $signature->act_id      = $act_id;
            $signature->idU         = $id_u;
            $signature->tipe        = 2;
            $signature->name        = $nom;
            $signature->description = $car;
            $signature->save();
            $cade.= ' "'.$id_u.'", ';
        }
    }
    ///fin de usuarios internos invitados

    $b = false;
    //agregar al secundario si hay cambio
    $act    = Act::find($act_id);
    $idu2   = $act->user_id2;
    if(!is_null($idu2)){
        $firm_id = busca_id_fir($act_id);
        foreach($firm_id as $f_u_id){
            $id_uf = $f_u_id->idU;///sacamos el id de firma usuario
            if($idu2==$id_uf){ ///comparamos si son iguales
                $b=true;
            }
        }
        if(!$b){

            $nom        = buscanombre($idu2);
            $car        = buscadescri($idu2);
            $signature  = new Signature;
            $signature->act_id      = $act_id;
            $signature->idU         = $idu2;
            $signature->tipe        = 3;
            $signature->name        = $nom;
            $signature->description = $car;
            $signature->save();
            $cade.= ' "'.$idu2.'", ';

        }
    }
    ////hacer cambios a los miembros del comite
    $firm_id = busca_id_fir($act_id);
    $comte_id=$act->committee_id;
    $user_id=$act->user_id;
    ///agregamos a lo miembros del comite preguntamos que si estoy en uno
    if(estoy_en_miembros($act_id,$user_id)){//// estoy en miembros
        $principal    = busca_miembro_yo($comte_id,$user_id);//// busca_miembros_yo
        foreach($principal as $a_u_id){ //$a_u_id
            $b = false;
            $id_u = $a_u_id->id;///sacamos el id de acta usuario
            foreach($firm_id as $f_u_id){
                $id_uf = $f_u_id->idU;///sacamos el id de firma usuario
                if($id_u==$id_uf&&$b==false){ ///comparamos si son iguales
                    $b=true;
                }
            }
            if(!$b){
                $nom        = buscanombre($id_u);
                $car        = buscadescri($id_u);
                $signature  = new Signature;
                $signature->act_id      = $act_id;
                $signature->idU         = $id_u;
                $signature->tipe        = 1;
                $signature->name        = $nom;
                $signature->description = $car;
                $signature->save();
                $cade.= ' "'.$id_u.'", ';
            }
        }

    }else{
        $principal    = busca_miembros($comte_id, $act_id);////busca miembros normal
        foreach($principal as $a_u_id){ //$a_u_id
            $b = false;
            $id_u = $a_u_id->id;///sacamos el id de acta usuario
            foreach($firm_id as $f_u_id){
                $id_uf = $f_u_id->idU;///sacamos el id de firma usuario
                if($id_u==$id_uf&&$b==false){ ///comparamos si son iguales
                    $b=true;
                }
            }
            if(!$b){
                $nom        = buscanombre($id_u);
                $car        = buscadescri($id_u);
                $signature  = new Signature;
                $signature->act_id      = $act_id;
                $signature->idU         = $id_u;
                $signature->tipe        = 1;
                $signature->name        = $nom;
                $signature->description = $car;
                $signature->save();
                $cade.= ' "'.$id_u.'", ';
            }
        }
    }
    if(estoy_en_miembros($act->id,$act->user_id)){
        $comite = Signature::where('act_id', $act->id)->where('idU', $act->user_id)->update(['tipe' => 1]);
    }else{
        $comite = Signature::where('act_id', $act->id)->where('idU', $act->user_id)->update(['tipe' => 3]);
    }
    return $cade;
}

function busca_id_del($act_id){//Compara
    $value = 0;
    ///generamos las firmas  del acta en base  alos id usuarios invitados internos
    $fir =busca_id_fir($act_id);////generamos las firmas ya establecidas
    foreach($fir as $fi){
        $b=false;
        $f = $fi->idU;///extraemos el id para comparar

        $uses = busca_id_act($act_id);
        foreach($uses as $us){
            $u = $us->user_id;///sacamos las firmas de usarios invitados internos

            if($f==$u){
                $b=true;
            }
        }
        if(!$b){
            ///aqui deberiamos preguntar si somos parte del comite o no
            $act = Act::find($act_id);
            $comte_id =$act->committee_id;
            $user_id=$act->user_id;
            if(estoy_en_miembros($act_id,$user_id)){
                $principal    = busca_miembro_yo($comte_id,$user_id);
                foreach($principal as $princi){
                    $c = $princi->id;///id firmas de comite
                    if($f==$c){
                        $b=true;
                    }
                }
            }else{
                $principal    = busca_miembros($act->committee_id,$act->id);
                foreach($principal as $comit){
                    $c = $comit->id;///sacamos firmas de comite
                    if($f==$c){
                        $b=true;

                    }
                }
            }

            if(!$b){
                $u2 = $act->user_id2;
                $u1 = $act->user_id;
                if($f==$u2){
                    $b=true;

                }elseif($f==$u1){
                    $b=true;

                }
            }

        }
       ///preguntamos aqui
       if(!$b){
            $id_uss=Signature::where('idU', $f)->where('act_id', $act_id);
            $id_uss->delete();
            $value++;
       }
    }
    return $value;
}

function busca_remplaza($id,$idr){///donde el $id es el id a buscar y $idr es el id remplazante
    ///en caso de que haya remplazamos por el usuario normal
    $member = Committee_User::where('user_id', $id)
            ->update(['user_id' => $idr]);
    return true;
}

function busca_ex_rempla($id){////funcion para buscar el remplazante de una ID
    $user    = User::find($id);
    return $user->replace;
}

function busca_elimina_rempl($id){
    $user    = User::find($id);
    $user->replace = null;
    $user->save();
    return true;
}

function acta_firmada($act_id){
    $cont_m=contar_met($act_id);
    $cont_f=contar_act($act_id);
    if($cont_f==$cont_m){
        return true;
    }else{
        return false;
    }
}

function genera_correos ($act_id,$user_id){
    $correos    = DB::table('users')
                ->select('users.id','users.email','users.name')
                ->join('signatures', 'signatures.idU','=','users.id' )
                ->where('signatures.act_id','=',$act_id)
                ->where('users.id','<>',$user_id)
                ->get();
    return $correos;
}
function genera_correos_yo ($act_id){
    $correos    = DB::table('users')
                ->select('users.id','users.email','users.name')
                ->join('signatures', 'signatures.idU','=','users.id' )
                ->where('signatures.act_id','=',$act_id)
                ->get();
    return $correos;
}
function genera_correos_re ($act_id){
    $correos    = DB::table('users')
                ->select('users.id','users.email','users.name')
                ->join('resolution_users', 'resolution_users.user_id','=','users.id' )
                ->join('orders','orders.id','=','resolution_users.order_id')
                ->join('acts','acts.id','=','orders.act_id')
                ->where('acts.id','=',$act_id)
                ->get();
    return $correos;
}
function act_list(){
    $actas = Act::all();
    return $actas;
}
function reso_list(){
    $reso   = DB::table('resolution')
            ->select('*')
            ->orderby('id', 'DSC')
            ->paginate(4);
    return  $reso;
}
function estado_acta($act_id){
    $act=Act::find($act_id);
    $est=$act->state_id;
    return $est;
}

function busca_pregunta($comite_id,$user_id){
    $es = false;
    $comi   =   DB::table('committee_users')
                ->where('committee_id','=',$comite_id)
                ->select('user_id')
                ->get();
    foreach($comi as $com){
        $u_id= $com->user_id;
        if($u_id==$user_id){
            $es=true;
        }
    }
    return $es;
}

function busca_comite_rem($comite_id,$user_id,$user_id_r){
    $comite = Committee_User::where('committee_id', $comite_id)
                        ->where('user_id', $user_id)
                        ->update(['user_id' => $user_id_r]);
    return $comite;
}

function cuenta_actas($committee_id){
    $invi   = DB::table('acts')
            ->where('committee_id', $committee_id)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $invi->counteo;
    ///colocamos el restador de  actas
    $comite = Committee::find($committee_id);
    $cantidad = $cantidad- $comite->year_tot;
    return $cantidad;
}

function muestra_correlativo($act_id){
    $act = Act::find($act_id);
    $correlativo = $act->correlative;
    return $correlativo;
}

function company_name($company_id){
    $company = Company::find($company_id);
    return $company->name;
}

function nombre_comite($comite_id){
    $comite = Committee::find($comite_id);
    return $comite->name;
}

function ver_firma_3($act_id){
    $invi   = DB::table('signatures')
            ->where('act_id', $act_id)
            ->where('tipe', 3)
            ->select(DB::raw('count(*) as counteo'))
            ->first();
    $cantidad = $invi->counteo;
    return $cantidad;

}

function ordena_resolucion(){
    $resoluciones = Resolution::all();
    $numerico = 1;
    foreach($resoluciones as $resolucion){
        $reso = Resolution::find($resolucion->id);
        $correla = correlativo($numerico);
        $reso->id = $correla;
        $reso->save();
        $numerico++;
    }
    return true;
}

function miembros_comite($committee_id){
    $users =DB::table('users')->
                join('committee_users', 'users.id','=','committee_users.user_id')->
                where('committee_users.committee_id', $committee_id)->
                select('users.name', 'users.id')->
                get();
    return $users;
}

function miembros_departamento($departament_id){
    $users =  DB :: table('users')->
                    join('departaments', 'users.departament_id','=','departaments.id')->
                    where('departaments.id', $departament_id)->where('deleted_at',null)->select('users.name', 'users.id')->orderBy('users.name','DSC')->get();
    return $users;
}

function miembros_departamentos($dep_ids = null){
    if(is_null($dep_ids))
        return 0;
    $users = \App\User::wherein('departament_id',$dep_ids)->where('id','!=',Auth::User()->id)->select('departament_id','name','id')->orderBy('users.name','ASC')->get();
    return $users;
}

function guarda_acta($act_id){
    $act        = Act::find($act_id);
    $guests     = busca_guests($act_id);
    $orders     = busca_orders($act_id);
    $firmados   = busca_firmas($act_id);
    $pdf = PDF::loadView('orders.vp',compact('act','guests','orders','firmados'));
    $path = Storage::disk('public')->put('actas/acta_'.$act_id.'-'.date("Y", strtotime($act->date)).'_mod-'.$act->mod.'.pdf', $pdf->output());
    $parche = 'actas/acta_'.$act_id.'-'.date("Y", strtotime($act->date)).'_mod-'.$act->mod.'.pdf';
    $act->pdf = $parche;
    $act->save();
    return $path;
}
function esta_n_acta($act_id, $user_id){
    $act = Act::find($act_id);
    $ba = false;
    if($act->user_id == $user_id){
        return true;
    }
    if(!is_null($act->user_id2)){
        if($act->user_id2==$user_id){
            return true;
        }
    }
    $prinici = busca_miembros($act->committee_id,$act->id);
    foreach ($prinici as $prin) {
        if($user_id == $prin->id&& !$ba){
            $ba=true;
        }
    }
    if($ba){
        return $ba;
    }
    $users = busca_users($act->id);
    foreach ($users as $use){
        if($use->id == $user_id && !$ba){
            $ba=true;
        }
    }
    if($ba){
        return $ba;
    }
    return $ba;
}


function chekar($action='cifrar',$string=false){
    $action = trim($action);
    $output = false;
    $myKey = 'LedZeppelin1970';
    $myIV = 'StairwayToHeaven';
    $encrypt_method = 'AES-256-CBC';
    $secret_key = hash('sha256',$myKey);
    $secret_iv = substr(hash('sha256',$myIV),0,16);
    if ( $action && ($action == 'cifrar' || $action == 'decifrar') && $string )
    {
        $string = trim(strval($string));
        if ( $action == 'cifrar' )
        {
            $output = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
            $output = str_replace("/", "_", $output);
            $output = str_replace("=", "-", $output);
        };

        if ( $action == 'decifrar' )
        {
            $string = str_replace("_", "/", $string);
            $string = str_replace("-", "=", $string);
            $output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);

        };
    };
    return $output;
};

function groupByType($act = null){
    
    if(is_null($act)){
        return null;
    }
    $type = $act->type;
    $group_id = $act->committee_id;
    switch ($type) {
        case 'A':
            return Committee::find($group_id)->name;
            break;
        case 'B':
            $departaments = $act->departaments()->get()->pluck('name');
            foreach ($departaments as $key ) {
                echo $key."<br>";
            }
            return App\Departament::find($group_id)->name;
            break;
        default:
            return '';
            break;
    }
}

function dateTimeFormat($date, $type = ''){
    $anio = substr($date,0,4);
    $mes = substr($date,5,2);
    $dia = substr($date,8,2);
    $hor = substr($date,11,2);
    $min = substr($date,14,2);
    $seg = substr($date,17,2);
    switch ($type) {
        case '':
            return $dia.'/'.$mes.'/'.$anio.' - '.$hor.':'.$min.':'.$seg;
            break;
        case 'date':
            return $dia.'/'.$mes.'/'.$anio;
            break;
        case 'time':
            return $hor.':'.$min.':'.$seg;
            break;
        case 'MD':
            return $hor.':'.$min.':'.$seg;
            break;
        case 'forHumans':
            # code...
            break;
        default:
            # code...
            break;
    }
}
function is_valid_email($str)
{
  $matches = null;
  return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
}

function verificateEmail($email){
    if(!strlen($email)>5){
        return false;
    }
    if (!is_valid_email($email)){
        return false;
    }
    $domain = explode('@', $email);
    if (checkdnsrr($domain[1]))
        return true;
    else
        return false;
}