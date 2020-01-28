<?php

namespace App;

use App\Product;
use App\Scopes\SellerScopes;
use App\Transformers\sellerTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends User
{

    public $seller = new sellerTransformer();

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScopes);
    }
    /**
     * function relation seller one-to-many to product
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
