<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use SoftDeletes;
    protected $table = "guests";
    protected $primaryKey = 'id';
    public $incrementing = true;


    protected $fillable = [
        'name',
        'company_id',
        'description',
        'institution',
        'phone',
        'email'
    ];

    protected $dates = ['deleted_at'];
    ///foraneas
    public function acts()
    {
        return $this->belongsToMany('App\Act');
    }
    public function company()
    {
        return $this->belongsTo('App\Company','company_id');
    }
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }
}
