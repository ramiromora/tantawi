<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee_User extends Model
{
    protected $table = "committee_users";
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'id','committee_id','user_id',
    ];

    ///foraneas
    public function user()
    {
        return $this->belongsToMany(Guest::class);
    }

    public function committee()
    {
        return $this->belongsToMany(Act::class);
    }
}
