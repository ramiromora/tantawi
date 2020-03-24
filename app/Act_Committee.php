<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Act_Committee extends Model
{
    protected $table = "act_committees";
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'act_id','committee_id','user_id'
    ];

    ///foraneas
   

    public function act()
    {
        return $this->belongsToMany(Act::class);
    }
}
