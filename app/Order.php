<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'id','act_id','order','body'
    ];
    public function act()
    {
        return $this->belongsTo(Act::class);
    }
    public function resolution(){
        return $this->hasMany(Resolution::class);
    }
   
}
