<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    protected $table = "departaments";
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'id','name'
    ];

}
