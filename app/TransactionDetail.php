<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TestUuids;

class TransactionDetail extends Model
{
    use SoftDeletes;
    use TestUuids;

    protected $table = 'transaction_details';
    protected $dates = ['deleted_at'];
    protected $fillable = ['transaction_id', 'name', 'slug', 'qty', 'price', 'amount'];
    public $incrementing = false;

    public function transaction(){
        $this->belongsTo(Transaction::class, "transaction_id");
    }
}
