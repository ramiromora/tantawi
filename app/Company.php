<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "company";
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'name','tradename'
    ];
    public function acts()
    {
        return $this->HasMany('App\Act');
    }

    public function guests()
    {
        return $this->HasMany('App\Guest');
    }
}
