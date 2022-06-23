<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class TransactionDetail extends Model
{
    use SoftDeletes;
    use Uuids;

    protected $table = 'transaction_details';
    protected $dates = ['deleted_at'];
    protected $fillable = ['transaction_id', 'product_id', 'name', 'slug', 'qty', 'price', 'amount'];
    public $incrementing = false;

    public function transaction(){
        return $this->belongsTo(Transaction::class, "transaction_id");
    }

    public function product(){
        return $this->belongsTo(Product::class, "product_id");
    }
}
