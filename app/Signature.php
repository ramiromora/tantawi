<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $table = "signatures";
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['id','act_id','idu','tipe','name','description','state'];
    public function act()
    
    {
        return $this->belongsToMany(Act::class);
    }
   
}
