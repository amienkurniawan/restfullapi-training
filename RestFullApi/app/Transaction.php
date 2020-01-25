<?php

namespace RestFullAPIAmien;

use Illuminate\Database\Eloquent\Model;
use RestFullAPIAmien\Buyer;
use RestFullAPIAmien\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

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
