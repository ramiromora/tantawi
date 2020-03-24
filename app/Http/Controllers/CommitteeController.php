<?php

namespace App\Http\Controllers;
use App\Committee;
use Illuminate\Http\Request;
use App\Committee_User;

class CommitteeController extends Controller
{
    public function index(){
        $committees = Committee::all();
        $users = userlist();
        return view('committee.index', compact('committees','users'));
    }

    public function show($id){
        $committee = Committee::find($id);
        return view('committee.index', compact('$committee'));
    }
    
    public function store(Request $request){

        $committee = new Committee;
        $committee->u_id = Auth()->user()->id; 
        $committee->name = $request->name;
        $committee->save();
        flash('comite Nro. '.$committee->id.' "'.$committee->name.'" creado correctamente')->success();
        $committees = Committee::all();
        $users = userlist();
        return view('committee.index', compact('committees','users'));
    }

    public function edit($id){
        $committee = Committee::find($id);
        $committees = Committee::all();
        $users = userlist();
        return view('committee.edit', compact('committee','committees','users'));
    }

    public function update(Request $request){
        $committee = Committee::find($request->comite_id);
        $committee->name = $request->name;
        $committee->save();
        flash('comite Nro. '.$committee->id.' "'.$committee->name.'" editado correctamente')->success();
        $committees = Committee::all();
        $users = userlist();
        return view('committee.index', compact('committees','users'));
    }

    public function destroy($id){
        $committee  = Committee::find($id);
        $committee  ->delete();
        flash('comite Nro. '.$committee->id.' "'.$committee->name.'" borrado correctamente')->info();
        $committees = Committee::all();
        $users = userlist();
        return view('committee.index', compact('committees','users'));
    }
    public function member(Request $request){
        $user_id    = $request->user_id;
        $comte_id   = $request->comte_id;
        $member = new Committee_User;
        $member->committee_id   = $comte_id;
        $member->user_id        = $user_id;
        $member->save();
        flash(buscanombre($member->user_id).' fue agregado exitosamente a comite Nro. '.$comte_id)->success();
        $committees = Committee::all();
        $users = userlist();
        return view('committee.index', compact('committees','users'));

    }
    public function member_del(Request $request){        
        $committee_id   = $request->committee_id;
        $user_id        = $request->user_id;
        $user_c = Committee_User::where('user_id', $user_id)->where('committee_id',$committee_id)->delete();
        flash(buscanombre($user_id).' fue eliminado exitosamente del comité Nro. '.$committee_id)->success();
        $committees = Committee::all();
        $users = userlist();
        return view('committee.index', compact('committees','users'));

    }
    
}
