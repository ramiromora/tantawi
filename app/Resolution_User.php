<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resolution_User extends Model
{
    protected $table = "resolution_users";
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'order_id','resolution_id','user_id',
    ];

    ///foraneas
    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function resolution()
    {
        return $this->belongsToMany(Resolution::class);
    }
}
