<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $table = 'accounts';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id','name','slug'];
    public $incrementing = false;

    public function transaction(){
        return $this->hasMany(Transaction::class, "account_id", "id");
    }
}
