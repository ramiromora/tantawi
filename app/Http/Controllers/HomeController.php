<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Adldap\AdldapInterface;

class HomeController extends Controller
{
    
    protected $ldap;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdldapInterface $ldap)
    {
        $this->ldap = $ldap;
        $this->middleware('auth');
    }

    public function index()
    {
        \Session::put('item', '1.');
        $notifiationsC = null;
        $notifiationsC = list_x_comte(Auth()->user()->id);
        $ids = \App\Act_User::where('user_id',Auth()->user()->id)->where('created_at','>',date('Y-01-01 00:00:00'))->pluck('act_id')->toarray();
        $acts = \App\Act::wherein('id',$ids)->where('state_id','>','1')->get();
        return view('home', compact('notifiationsC','acts'));
    }
    public function ldap($name){
        if($name!=''){
            $use = $this->ldap->search()->users()->find($name);
            if(!is_null($use)){
                //dd($use);
                return dd($use);//->uidnumber[0];
            }else{
                return 'sin resultados';
            }
            
        }else{
            return 'Por favor ingrese una palabra en la busqueda';
        }
    }
}
