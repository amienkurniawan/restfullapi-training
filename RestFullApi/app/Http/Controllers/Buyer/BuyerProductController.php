<?php

namespace RestFullAPIAmien\Http\Controllers\Buyer;

use RestFullAPIAmien\Buyer;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class BuyerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $product = $buyer->transactions()->with('products')->get()->pluck('products');
        return $this->showAll($product);
    }
}
