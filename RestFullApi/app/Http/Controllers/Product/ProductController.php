<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        foreach (request()->query() as $query => $value) {
            $attribute = ProductResource::originalAttribute($query);
            if (isset($attribute, $value)) {
                $products = $products->where($attribute, $value);
            }
        }
        if (request()->has('sort_by')) {
            $attribute = ProductResource::originalAttribute(request()->sort_by);
            $products = $products->sortBy->{$attribute};
        }
        $products = self::paginate($products);
        return ProductResource::collection($products)->values();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
