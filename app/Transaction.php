<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Transaction extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'transactions';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','account_id','slug','description','transaction_type','transaction_date','images','amount'];
    public $incrementing = false;

    public function details(){
        return $this->hasMany(TransactionDetail::class, "transaction_id", "id");
    }

    public function account(){
        return $this->belongsTo(Account::class, "account_id");
    }
}
