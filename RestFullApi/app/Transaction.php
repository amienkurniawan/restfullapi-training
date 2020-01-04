<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;

class Transaction extends Model
{
    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id'
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
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
