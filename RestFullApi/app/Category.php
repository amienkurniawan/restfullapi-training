<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    /**
     * function relationship category many-to-many to product
     */
    public function products()
    {
        return $this->belongsToMany(product::class);
    }
}
