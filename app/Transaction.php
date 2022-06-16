<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TestUuids;

class Transaction extends Model
{
    use SoftDeletes;
    use TestUuids;

    protected $table = 'transactions';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','slug','description','transaction_type','transaction_date','images','amount'];
    public $incrementing = false;

    public function details(){
        $this->hasMany(TransactionDetail::class, "transaction_id", "id");
    }
}
