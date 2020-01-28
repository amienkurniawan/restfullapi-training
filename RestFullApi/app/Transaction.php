<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
use App\Product;
use App\Transformers\transactionTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public $transaction = new transactionTransformer();

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'quantity',
        'buyer_id',
        'products_id'
    ];

    /**
     * function relation transaction one-to-many to buyer
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    /**
     * function relation transaction one-to-many to product
     */
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
