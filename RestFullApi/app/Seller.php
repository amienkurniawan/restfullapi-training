<?php

namespace App;

use App\Product;
use App\Scopes\SellerScopes;

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
