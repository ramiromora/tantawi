<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    //para generar las consultas externas con ajax
    public function cargo(Request $request){        
        return gen_carg($request->id);
    }    
    public function comite(Request $request){        
        return miembros_comite($request->id);
    }    
    public function department(Request $request){
        //return miembros_departamento($request->ids);
        return miembros_departamentos($request->ids);
    }
}
