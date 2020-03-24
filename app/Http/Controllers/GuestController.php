<?php

namespace App\Http\Controllers;

use App\Guest;
use App\Act_Guest;
use App\Act_User;
Use App\User;
Use App\Act;
use Validator;
use Response;
use Iluminate\suppert\facades\input;
use App\http\Requests;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class GuestController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    } 

    public function index(){
        \Session::put('item', '4.1:');
        $contacts = Guest::all();
        return view('guests.index', compact('contacts'));
    }
    public function store(Request $request){
        $dataFill = $request->except('_token');
        $guest = Guest::create($dataFill);
        if(!is_null($guest)){
            return 1;
        }
        return 0;
    }
    //verificador de seccion
    ///agregamos un invitado de los usuarios
    public function add(Request $request){
        //buscar los datos enviadoes en el array  
        $act_id         = $request->act_id;       
        ////PROCEDIMIENTOS
        $name           = $request->name;
        $description    = $request->description;
        $company        = $request->company;
        $institution    = $request->institution;
        $guest = new Guest;
        $guest->name        = $name;
        $guest->description = $description;
        $guest->company_id  = $company;
        $guest->institution = $institution;
        $guest->save();
        $guest_id = $guest->id;
        ///agregamos a la relacion
        $actguest =new Act_Guest;
        $actguest ->guests_id   = $guest_id;
        $actguest ->act_id    = $act_id;
        $actguest ->save();
        $act = Act::find($act_id);
        $guests         = busca_guests($act_id);
        $users          = busca_users($act_id);
        $principal      = busca_miembros($act->committee_id, $act->id);
        $nousers        = userlist();
        
        return view('guests.new', compact('act','users','guests','principal','nousers'));
    }
        //recuerda q la funcion de mostra tiene q estar filtrada
    public function delGuest(request $request){
        $act_id = $request->act_id;        
        $id     = $request->id;
        $act = Act::find($act_id);
        $Guest  = Guest::find($id)->delete();
        $guests         = busca_guests($act_id);
        $users          = busca_users($act_id);
        $principal      =  busca_miembros($act->committee_id, $act->id);
        $nousers        = userlist();
        return view('guests.new', compact('act','users','guests','principal','nousers'));   
    }    

    public function delete($id){
        Guest::find($id)->delete();
        toastr()->warning('Contacto eliminado');
        return redirect()->back();
    }


    public function edit($id){
        $guest = Guest::find($id);
        return view('guests.edit', compact('guest'));
    }
    public function update(Request $request){
        $guest = Guest::find($request->id);
        $guest->update($request->all());
        toastr()->success('Contacto Actualizado');
        return redirect('guest/'.$request->id.'/edit');
    }
}
