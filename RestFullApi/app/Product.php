<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Seller;
use App\Transaction;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];
    /**
     * function to check if product available
     */
    public function isAvailable()
    {
        return $this->status == Product::AVAILABLE_PRODUCT;
    }
    /**
     * function relation product many-to-many to categories
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * function relation product one-to-many to seller
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * function relation product one-to-many to transaction
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'products_id');
    }
}
