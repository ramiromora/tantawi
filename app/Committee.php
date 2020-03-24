<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Committee extends Model
{
    use SoftDeletes;

    protected $table = "committee";
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'id','name','description','user_id','deleted_at'
    ];

    ///foraneas
    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function act()
    {
        return $this->belongsToMany(Act::class);
    }
}
