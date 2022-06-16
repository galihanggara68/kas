<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\TestUuids;

class User extends Authenticatable
{
    use Notifiable;
    use TestUuids;
    use SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    public $incrementing = false;

    protected $fillable = [
        'name','username','email','password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role')->withTrashed();
    }
}
