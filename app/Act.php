<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Act extends Model
{
    use SoftDeletes;

    protected $table = "acts";
    protected $primaryKey = 'id';
    public $incrementing = true;
    
    protected $fillable = [
        'id',
        'user_id',
        'user_id2',
        'company_id',
        'quantity',
        'title',
        'date',
        'datef',
        'time',
        'timef',
        'state_id',
        'committee_id',
        'correlative',
        'addres',
        'mod',
        'location',
        'type',
        'content',
        'agreements'
    ];
    
    protected $dates = ['deleted_at'];

    ///foraneas
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }

    public function signature()
    {
        return $this->hasMany(Signature::class);
    }

    public function companys()
    {
        return $this->belongsToMany('App\Company');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function participants($type = true)
    {
        if ($type)
            return Act_User::where('act_id',$this->id);
        else 
            return Act_Guest::where('act_id',$this->id);
    }

    /**
     * La funcion Users devuelve la coleccion de los usarios registrados con el convocate
     */
    // public function users (){
    //     return \App\User::whereIn('id',$this->participants()->pluck('user_id')->toarray());
    // }

    public function guests (){
        return \App\Guest::whereIn('id',$this->participants(false)->pluck('guest_id')->toarray());
    }

    /**
     * La funcion convocate realiza la relacion de los usuarios dle sistema con el acta
     */

    function convocate($users_ids = array(),$type = true)
    {
        $cant = 0;
        if($type){
            \App\Act_User::where('act_id',$this->id)->delete();
            if(!is_null($users_ids)){
                foreach($users_ids as $user_id){
                    $inv = new \App\Act_User;
                    $inv->user_id = $user_id;
                    $inv->act_id = $this->id;
                    if($inv->save()){
                        $cant++;
                    }
                }
            }
        }else{
            \App\Act_Guest::where('act_id',$this->id)->delete();
            if(!is_null($users_ids)){
                foreach($users_ids as $user_id){
                    $inv = new \App\Act_Guest;
                    $inv->guest_id = $user_id;
                    $inv->act_id = $this->id;
                    if($inv->save()){
                        $cant++;
                    }
                }
            }
        }
        return $cant;
    }

    public function refreshGuests(){
        $emp = $this->companys()->get()->pluck('id')->toarray();
        $partici = $this->guests()->get();
        foreach($partici as $part){
            if(!in_array($part->company_id,$emp)){
                Act_Guest::where('act_id',$this->id)->where('guest_id',$part->id)->first()->delete();
            }
        }

    }

    public function departaments()
    {
        return $this->belongsToMany('App\Departament');
    }

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }
}
