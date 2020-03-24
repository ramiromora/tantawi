<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'id','name','username','samaccountname','description','department','mail','number'
    ];

    protected $hidden = [
        'password',
    ];
    
////foraneas
    public function acts()
    {
        return $this->HasMany('App\Act');
    }
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }
}
