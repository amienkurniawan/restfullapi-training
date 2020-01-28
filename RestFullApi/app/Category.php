<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Transformers\categoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    public $category = new categoryTransformer();

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
    ];
    protected $hidden = ['pivot'];
    /**
     * function relationship category many-to-many to product
     */
    public function products()
    {
        return $this->belongsToMany(product::class);
    }
}
