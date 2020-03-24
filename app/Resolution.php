<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resolution extends Model
{
    protected $table = "resolution";
    protected $primaryKey = 'id';
    public $incrementing = false;


    protected $fillable = [
        'id','order_id','title','body','date','term'
    ];
    public function actorder()
    {
        return $this->belongsTo(Order::class);
    }
}
