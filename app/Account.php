<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TestUuids;

class Account extends Model
{
    use SoftDeletes;
    use TestUuids;

    protected $table = 'accounts';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id','name','slug'];
    public $incrementing = false;
}
