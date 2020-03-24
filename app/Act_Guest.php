<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Act_Guest extends Model
{
    protected $table = "act_guest";
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'id','guest_id','act_id'
    ];

    ///foraneas
    public function guest()
    {
        return $this->belongsToMany(Guest::class);
    }

    public function act()
    {
        return $this->belongsToMany(Act::class);
    }
}
