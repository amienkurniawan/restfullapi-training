<?php

namespace RestFullAPIAmien;

use RestFullAPIAmien\Product;
use RestFullAPIAmien\Scopes\SellerScopes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends User
{


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
