<?php

namespace App;

use App\Product;

class Seller extends User
{
    /**
     * function relation seller one-to-many to product
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
