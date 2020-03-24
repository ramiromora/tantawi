<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Act_User extends Model
{
    protected $table = "act_user";
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'id','user_id','act_id'
    ];

    ///foraneas 
    
}
