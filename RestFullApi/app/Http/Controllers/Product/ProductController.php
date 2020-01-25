<?php

namespace RestFullAPIAmien\Http\Controllers\Product;

use RestFullAPIAmien\Product;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \RestFullAPIAmien\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }
}
