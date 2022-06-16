<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TestUuids;

class Setting extends Model
{
    use SoftDeletes;
    use TestUuids;

    protected $table = 'settings';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id','name','slug','type','description'];
    public $incrementing = false;
}
