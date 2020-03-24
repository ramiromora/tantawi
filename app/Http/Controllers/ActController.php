<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Act;
use App\Company;
use App\Committee;
use App\Guest;
use App\Act_Guest;
use App\User;
use Illuminate\Support\Facades\DB;///para realizar la consulta personalizada
use App\Signature;
use Mail;
use App\Mail\Notification;
use App\Mail\Renotificar;
use App\Act_Committee;
use Barryvdh\DomPDF\Facade as PDF;

class ActController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        ///lista de mis actas
        \Session::put('item', '2.1:');
        $acts =Act::where('user_id','=', Auth()->user()->id)->
                    orderBy('acts.id', 'DSC')->
                    get();
       
        ///lista de mis actas co convocadas y q no sean borrador
        $acts_co=DB::table('acts')
                ->join('company', 'company.id', '=' , 'acts.company_id')
                ->join('committee', 'committee.id', '=' , 'acts.committee_id')
                ->where('user_id2','=', Auth()->user()->id)
                ->where('state_id','>=','2')
                ->select('acts.id','acts.user_id','acts.title', 'committee.name', 'company.tradename', 'acts.date','acts.time', 'acts.state_id')

                ->orderBy('acts.id', 'DSC')
                ->get();
        return view('acts.index',compact('acts','acts_co'));
    }

    public function list(){
        \Session::put('item', '2.2:');
        $acts = Act::wherein('user_id',\App\User::where('departament_id',\Auth::user()->departament_id)->pluck('id')->toarray())->where('state_id','>',1)->get();
        ///lista de mis actas co convocadas y q no sean borrador
        return view('acts.list',compact('acts'));
    }

    public function create($type = null){
        switch ($type) {
            case 'A':
                toastr()->warning('Atencion, Acta obsoleta','Obsoleto');
                return redirect()->back();
              //toastr()->info('Parametrizando Acta de Comites');
                $companys   = Company::orderBy('name', 'ASC')->pluck('name','id');
                $users      = DB::table('users')
                            ->where('id', '<>', Auth()->user()->id)
                            ->orderBy('name', 'ASC')
                            ->pluck('name','id');
                $committees = Committee::orderBy('name', 'ASC')->pluck('name','id');
                return view('acts.components.tipeA.new',compact('companys','users','committees'));
                break;
            case 'B':
                $companys   = Company::select(DB::raw("CONCAT  ('[',tradename,'] ', name) AS ".'"name" , "id"'))->orderBy('name', 'ASC')->pluck('name','id');
                $users      = User::where('id','!=',\Auth::user()->id)->orderBy('name','ASC')->pluck('name','id');
                $departments= \App\Departament::where('id','>',0)->orderBy('name', 'ASC')->pluck('name','id');
                $departamentos = parametrica_get('departamentos')->pluck('description','value');
                return view('acts.components.tipeB.create',compact('companys','users','departments','departamentos'));
                break;
            default:
                $tipes = parametrica_get('acta_tipos')->get();
                return view('acts.components.create',compact('tipes'));
            break;
        }
    }

    public function check($id){
        $act = Act::find($id);
        if(is_null($act)){
            toastr()->error('Error al ancontrar Acta','Error');
            return redirect()->back();
        }
        $act->correlative = Act::where('type','B')->where('committee_id',$act->committee_id)->where('state_id','>=',2)->get()->count()+1;
        $act->state_id = 2;
        if($act->save()){
            toastr()->success('Acta Validada','Validación Completa');
            return redirect()->back();
        }else{
            toastr()->warning('Acta no validada','Validación incompleta');
            return redirect()->back();
        }
    }

    public function archAct(){
        // lista de actas archivadas o por archivar
        $notifiations   = null;
        $notifiations   = actas_firmadas();
        // ver si nesesito mas de un dato
        return view('dashboard.archive',compact('notifiations'));
    }

    public  function newAct(){
        $companys   = Company::orderBy('name', 'ASC')->pluck('name','id');
        $users      = DB::table('users')
                    ->where('id', '<>', Auth()->user()->id)
                    ->orderBy('name', 'ASC')
                    ->pluck('name','id');
        $committees = Committee::orderBy('name', 'ASC')->pluck('name','id');
        return view('acts.new',compact('companys','users','committees'));
    }

//*******************************************************/
//****************GUARDAMOS EL ACTA NUEVA****************/
/********************************************************/
    public function store(Request $request){
        switch ($request->type) {
            case 'A':
                $act=new Act();
                $act->user_id       = $request->user_id;
                $act->user_id2      = $request->user_id2;
                $act->company_id    = $compani_id;
                $act->committee_id  = $request->committee_id;
                $act->title         = $request->title;
                $act->date          = $request->date;
                $act->time          = $request->time;
                $act->timef         = $request->timef;
                if($request->addres1=='nue'){
                    $act->addres    = $request->addres;
                }
                $act->correlative   = correlativo(cuenta_actas($request->committee_id)+1);
                $act->save();
                ////verificamos que los miembros del comite esten presentes
                if(is_null($request->members)){
                    $member = new Act_Committee;
                    $member->act_id = $act->id;
                    $member->committee_id = $request->committee_id;
                    $member->user_id = $request->user_id;
                    $member->save();
                    ///agrego a mi mismo como miembro del comite y me suprimo como responsable convocante
                }else{
                    $num_miembros = count($request->members);
                    $miembros = $request->members;
                    for($i = 0 ; $i<$num_miembros; $i++){
                        $membe = new Act_Committee;
                        $membe->act_id = $act->id;
                        $membe->committee_id = $request->committee_id;
                        $membe->user_id = $miembros[$i];
                        $membe->save();
                    }
                }
                $principal      = busca_miembros($request->committee_id, $act->id);
                $guests         = busca_guests($act->id);
                $users          = busca_users($act->id);
                $nousers        = userlist();
                //realizamos esta consulta para evitar eviar $guest vacio por q el formulario require de un array  guest
                return view('guests.new',compact('act','users','guests','principal','nousers'));
                break;
            case 'B':
                $dataFill = $request->except('companys','members','_token','addres1','addres');
                if($request->addres1=='nue')
                    $dataFill['addres'] = $request->addres;
                else
                    $dataFill['addres'] = 'Oficina Técnica para el Fortalecimiento de la Empresa Pública - OFEP';
                $dataFill['company_id'] = 0;
                $dataFill['committee_id'] = 0;
                $dataFill['correlative'] = 0;
                $act = Act::create($dataFill);
                $act-> companys()->attach($request->companys);
                $act-> departaments()->sync($request->departaments);
                if(!is_null($request->users)){
                    $arre = $request->users;
                    array_push ( $arre , (string)\Auth::user()->id );
                    $inv = $act->convocate($arre);
                }else{
                    $arre = array();
                    array_push ( $arre , (string)\Auth::user()->id );
                    $inv = $act->convocate($arre);
                }
                toastr()->success('Borrador Generado se Agregaron a '.$inv.' participantes','Acta Generada');
                $id = $act->id;
                return redirect()->route('act.show',compact('id'));
                break; 
            default:
                toastr()->error('Error al generar Acta','Error el acta no se pudo generar');
                return redirect()->back();
                break;
        }
    }

    public function show($id){
        $act = Act::find($id);
        if(is_null($act)){
            toastr()->error('Error acta no encontrada');
            return redirect()->back();
        }
        $orders         = busca_orders($id);
        $guests         = busca_guests($id);
        $firmados       = busca_firmas($id);
        switch ($act->type) {
            case 'A':
                return view('acts.components.tipeA.show',compact('act','guests','orders','firmados'));
                break;
            case 'B':
                return view('acts.components.tipeB.show',compact('act'));
                break;
            default:
                # code...
                break;
        }
    }

    public function edit($id,$type){
        $act = Act::find($id);
        
        switch ($type) {
            case 'header':
                
                //$query = "CONCAT  (`[`,tradename,`]`, name) AS "name", id";     DB::raw($query)
                $companys   = Company::where('group',0)->select(DB::raw("CONCAT  ('[',tradename,'] ', name) AS ".'"name" , "id"'))->orderBy('name', 'ASC')->pluck('name','id');
                $ids_dep = $act->departaments()->get()->pluck('id')->toarray();
                $users = \App\User::wherein('departament_id',$ids_dep)->where('id','!=',\Auth::user()->id)->orderBy('name', 'ASC')->pluck('name','id');
                $departments = \App\Departament::where('id','>',0)->orderBy('name', 'ASC')->pluck('name','id');
                $departamentos = parametrica_get('departamentos')->pluck('description','value');
                return view('acts.components.tipeB.edit',compact('act','type','companys','users','departments','departamentos'));
                break;
            case 'body':
                return view('acts.components.tipeB.edit',compact('act','type'));
                break;
            case 'participants':
                $companys = Company::whereIn('id',$act->companys()->get()->pluck('id')->toarray())->get();
                return view('acts.components.tipeB.edit',compact('act','type','companys'));
                break;
            default:
                return redirect()->back();
                break;
        }
    }
    
    public function update(Request $request){
        switch ($request->type) {
            case 'header':
                $dataFill = $request->except('companys','members','_token','addres1','addres','type','committee_id');
                if($request->addres1=='nue')
                    $dataFill['addres'] = $request->addres;
                else
                    $dataFill['addres'] = 'Oficina Técnica para el Fortalecimiento de la Empresa Pública - OFEP';
                $dataFill['company_id'] = 0;
                $dataFill['correlative'] = 0;
                $act = Act::find($request->id);
                $act-> update($dataFill);
                $act-> companys()->sync($request->companys);
                $act-> refreshGuests();
                $act-> departaments()->sync($request->departaments);
                if(!is_null($request->users)){
                    $arre = $request->users;
                    array_push ( $arre , (string)\Auth::user()->id );
                    $inv = $act->convocate($arre);
                }else{
                    $arre = array();
                    array_push ( $arre , (string)\Auth::user()->id );
                    $inv = $act->convocate($arre);
                }
                toastr()->success('Borrador actualizado se agregaron a '.$inv.' participantes','Acta Actualizada');
                $id = $act->id;
                return redirect()->route('act.show',compact('id'));
                break;
            case 'body':
                $dataFill = $request->except('type','agreements');
                if($request->agreements=="<p>&nbsp;&nbsp;</p>" && strlen($request->agreements) == 19)
                    $dataFill['agreements'] = null;
                else
                    $dataFill['agreements'] = $request->agreements;
                $act = Act::find($request->id);
                $act->update($dataFill);
                toastr()->success('Contenido actualizado ','Acta Actualizada');
                $id = $act->id;
                return redirect()->route('act.show',compact('id'));
                break;
            case 'participants':
                $act = Act::find($request->id);
                $inv = $act->convocate($request->guests,false);
                $id = $act->id;
                toastr()->success('Borrador actualizado se agregaron a '.$inv.' participantes','Acta Actualizada');
                return redirect()->route('act.show',compact('id'));
                break;
            default:
                toastr()->error('Error de Procedimiento','Error de Proceso');
                return redirect()->back();
                break;
        }
    }

    public function pdf($id){
        $act = Act::find($id);
        if(is_null($act)){
            toastr()->success('Error Acta no encontrada');
            return redirect()->back();
        }
        //return view('acts.components.tipeB.pdf',compact('act'));
        $pdf = PDF::loadView('acts.components.tipeB.pdf',compact('act'))->setPaper('letter', 'landscape');        
        return $pdf->stream();
    }


    public function autoSave(Request $request){
        $act = Act::find($request->id);
        $act->update($request->all());
    }

    public function sendEmail($id){
        $act = Act::find($id); 
        $pdf = PDF::loadView('acts.components.tipeB.copy',compact('act'))->setPaper('letter', 'landscape');
        $mesagge = new Notification($act);
        $mesagge->attachData($pdf->output(), "Acta-OFEP_".$act->correlative."_".$act->date.".pdf");
        $usuarios = $act->users()->where('email','<>',\Auth::user()->email)->get()->pluck('email')->toarray();
        $invitados = $act->guests()->get()->pluck('email')->toarray();
        $correos = array_merge($usuarios,$invitados);
        if(count($correos)<1){
            toastr()->error('Error no hay remitentes','Error');
            return redirect()->back();
        }
        $emails = array();
        foreach($correos as $correo){
            if(verificateEmail($correo)){
                array_push($emails,$correo);
            }
        }
        //dd($emails);
        $mail = Mail::to(\Auth::user()->email,\Auth::user()->name)->cc($emails);
        $mail->send($mesagge);
        if(!Mail::failures())
            toastr()->success('Correos enviados','Mensajes Enviados');
        else
            toastr()->error('Fallo al enviar Correos','Error');

        return redirect()->back();
    }

    public function delete($id){
        Act::find($id)->delete();
        toastr()->error('Atencion Acta Archivada', 'ACTA ARCHIVADA');
        return redirect(route('act.index'));
    }






































    

/**
 * fUNCIONES oBSOLETAS
 * 
 * 
 */
    public function updAct(Request $request){
        $act_id =$request->act_id;
        $act = Act::find($act_id);
        $act->fill($request->all())->save();
        if(!isset($request->new_institution)){
            $compani_id = $request->company_id;
        }else{
            $company = new Company;
            $company->name = $request->institution;
            $company->tradename = $request->institution;
            $company->save();
            $compani_id = $company->id;
        }
        $act->company_id    = $compani_id;
        if($request->addres1=='nue'){
            $act->addres = $request->addres;
        }else{
            $act->addres = 'la Oficina Técnica para el Fortalecimiento de la Empresa Pública - OFEP';
        }
        $act->save();

        //hacer la consulta aqui para compactar datos en base a $act_id
        ////// algoritmo para los miembros del comite participantes
        if(is_string($request->members)){
            if(cuenta_miembros($act_id)==1){
                if(!estoy_seteado_como_unico($act_id)){
                    $borra = Act_Committee::where('act_id', '=', $act->id)->delete();
                    $member = new Act_Committee;
                    $member->act_id = $act->id;
                    $member->committee_id = $request->committee_id;
                    $member->user_id = $request->user_id;
                    $member->save();
                }
            }else{
                $borra = Act_Committee::where('act_id', '=', $act->id)->delete();
                $member = new Act_Committee;
                $member->act_id = $act->id;
                $member->committee_id = $act->committee_id;
                $member->user_id = $act->user_id;
                $member->save();
            }
            ///agrego a mi mismo como miembro del comite y me suprimo como responsable convocante
        }else{
            if(!estoy_seteado_como_unico($act_id)){
                $borra = Act_Committee::where('act_id', '=', $act->id)->delete();/// me borro solito
                $num_miembros = count($request->members);
                $miembros = $request->members;
                for($i = 0 ; $i<$num_miembros; $i++){
                    $membe = new Act_Committee;
                    $membe->act_id = $act->id;
                    $membe->committee_id = $request->committee_id;
                    $membe->user_id = $miembros[$i];
                    $membe->save();
                }
            }else{
                $miembros = $request->members;
                $can = busca_agrega_mem_rempla($act_id,$miembros);
            }
            ///aqui seteamos con todos los cambios al comite o grupo q llevo la reunion
        }
        /////
        $guests     = busca_guests($act_id);
        $users      = busca_users($act_id);
        $principal  = busca_miembros($act->committee_id, $act_id);
        $nousers    = userlist();
        flash('Acta  <strong>'.$act_id.'/'.date("Y", strtotime($act->date)).' "'.$act->title.'"</strong> fue Actualizada exitosamente')->success();
        return view('guests.new',compact('act','users','guests','principal','nousers'));
    }


    public function editAct($id){///mandar las variables de los miembros del comite generar el script on load
        $act        = Act::find($id);
        $this->authorize('pass', $act);
        $companys   =  Company::orderBy('tradename', 'ASC')->pluck('name','id');
        $users=  DB::table('users')
                    ->where('id', '<>', Auth()->user()->id)
                    ->orderBy('name', 'ASC')
                    ->pluck('name','id');
        $committees = Committee::orderBy('id', 'ASC')->pluck('name','id');
        $members    = genera_miembros($act->id);
        return view('acts.edit',compact('companys','act','users','committees','members'));
    }

    public function editNoti(Request $request){
        $id=$request->id;
        $act    = Act::find($id);
        $this->authorize('pass', $act);
        $comte_id = $act->committee_id;
        $canti = 0;
        ///tenemos q contar firmas primero
        if($act->state_id==1){
            ///preguntamos si estoy en el comite
            if(!estoy_en_miembros($act->id,Auth()->user()->id)){ ///// estoy en miembros
                $canti++;
                //agregamos nuestra firma como convicante principal
                $signature = new Signature;
                $signature->act_id      = $id;
                $signature->idU         = Auth()->user()->id;
                $signature->tipe        = 3;
                $signature->name        = Auth()->user()->name;
                $signature->description = Auth()->user()->description;
                $signature->state       = 1;
                $signature->save();
                $principal = busca_miembros($act->committee_id, $act->id);
            }
            if(!is_null($act->user_id2)){
                ///PREGUNTAMOS SI EL CONVOCANTE SECUNDARIO ES DE UN COMITE
                if(!estoy_en_miembros($act->id,$act->user_id2)){
                $nombre = buscanombre($act->user_id2);
                $signature = new Signature;
                $signature->act_id      = $id;
                $signature->idU         = $act->user_id2;
                $signature->tipe        = 3;
                $signature->name        = $nombre;
                $signature->description = buscadescri($act->user_id2);
                $signature->state       = 0;
                $signature->save();
                $canti++;
                }
            }

            $principal    = busca_miembros($act->committee_id,$act->id);
            foreach($principal as $princi){
                $signature = new Signature;
                $signature->act_id      = $id;
                $signature->idU         = $princi->id;
                if($princi->id==Auth()->user()->id){
                    $signature->state   = 1;
                }else{
                    $signature->state   = 0;
                }
                $signature->tipe        = 1;
                $signature->name        = $princi->name;
                $signature->description = $princi->description;
                $signature->save();
                $canti++;
            }

            //agregar espacio de firmas de usuarios
            $users = busca_users($id);
            foreach($users as $user){
                $signature = new Signature;
                $signature->act_id      = $id;
                $signature->idU         = $user->id;
                $signature->tipe        = 2;
                $signature->name        = $user->name;
                $signature->description = $user->description;
                $signature->state       = 0;
                $signature->save();
                $canti++;
            }


            //agregar espacio de firmas de los invitados
            //en caso de existir agregar el espacio de firma del responsable conbocante secundario
        }elseif($act->state_id==3){
                //agregamos los cambios de invitados
                busca_id_add($id);          ///agrega los cambios en firmas de usuarios y convocante alterno y miembros de comite
                busca_id_del($id);          ///borra los anteriores en firmas de usuarios y convocante alterno y miembros de comite
                //si solo fue observado simplemente lo refirma
                $signature  = Signature::where('idU', auth()->user()->id)
                            ->where('act_id', $id)
                            ->update(['state' => 1]);
                $canti = cuenta_firmas($id);//cuenta firmas de todos los  usuarios invitados comite y convocantes
        }
        $titulo = $act->title;
        $act->state_id = 2;
        $act->quantity = $canti;
        $act->save();
        guarda_acta($act->id);
        $tex ='';
        // Enviamos correos a los responsables de las resoliciones
        $correos_re = genera_correos_re($id);
        foreach ($correos_re as $correo_r) {
            ///preguntamos si el responsable tiene q firmar
            $corre = genera_correos_yo($id,Auth()->user()->id);
            $ba = true;
            foreach ($corre as $cor) {
                $id_r=$correo_r->id;
                $id_f=$cor->id;
                if($id_r==$id_f){
                    $ba=false;//si llega aqui el responsable firma
                }
            }
            if($ba){ ///aqui verificamos si no firma le enviamos correo de responsable
                if(!is_null($correo_r->email)){
                    //envia al correo que no es null
                    $usr = User::find($correo_r->id);
                    Mail::to($correo_r->email,$correo_r->name)->send(new Renotificar($act,$usr));  ///enviamos correo a los responsables de alguna accion
                    if(!Mail::failures()){
                        $tex.= $correo_r->name.' <b>Enviado</b>, ';
                    }else{
                        $tex.=$correo_r->name.' <b>Fallo!</b>, ';
                    }
                }else{
                    $tex.=$correo_r->name.' <b>Sin Correo</b>, ';
                }
            }
        }
        ////enviamos el correo a firmantes
        $correos = genera_correos($id,Auth()->user()->id);
        foreach ($correos as $correo) {
            if(!is_null($correo->email)){
                //envia al correo que no es null
                $usr = User::find($correo->id);
                Mail::to($correo->email,$correo->name)->send(new Notification($act,$usr));
                if(!Mail::failures()){
                    $tex.= $correo->name.' <b>Enviado</b>, ';
                }else{
                    $tex.=$correo->name.' <b>Fallo!</b>, ';
                }
            }else{
                $tex.=$correo->name.' <b>Sin Correo</b>, ';
            }
        }
        //// renderisamos un pdf y lo guardamos en el disco

        flash('Acta  '.$id.'/'.date("Y", strtotime($act->date)).' "'.$titulo.'" fue notificado exitosamente, Se Requieren '.$canti.' Firmas, <br>Notificados: '.$tex)->success();
        return redirect()->route('act_list');
    }

    public function editDele(Request $request){
        $id = $request->id;
        $act = Act::find($id);
        $this->authorize('pass', $act);
        $act->delete();
        $titulo = $act->title;
        flash('Acta  <strong>'.$id.' - "'.$titulo.'"</strong> fue ELIMINADA exitosamente')->error();
        return redirect()->route('act_list');
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function list_notifi(){
        $notifiationsC = null;
        $notifiationsC = list_x_comte(Auth()->user()->id);
        //ver si nesesito mas de un dato
        return view('dashboard.index', compact('notifiationsC'));
    }
    public function archivar($act_id){
        $act = Act::find($act_id);
        $act->state_id=5;
        $act->id_rech=Auth()->user()->id;
        $act->save();
        guarda_acta($act_id);
        $notifiations   = null;
        $notifiations   = actas_firmadas();
        flash('Acta '.$act_id.'/'.date("Y", strtotime($act->date)).' fue Archivada exitosamente')->success();
        return view('dashboard.archive',compact('notifiations'));
    }

    public function show_ne($id){
        $act = Act::find($id);
        $guests         = busca_guests($id);
        $users          = busca_users($id);
        $principal      = busca_miembros($act->committee_id,$act->id);////modificar aqui---------------------------------------------------------------///////////////////////////////////
        $orders         = busca_orders($id);
        return view('acts.show_ne',compact('act','guests','orders','users','principal'));
    }



}
