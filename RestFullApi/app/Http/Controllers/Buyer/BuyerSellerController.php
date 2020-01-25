<?php

namespace RestFullAPIAmien\Http\Controllers\Buyer;

use RestFullAPIAmien\Buyer;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class BuyerSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $seller = $buyer->transactions()->with('products.seller')
            ->get()
            ->pluck('products.seller')
            ->unique('id')
            ->values()
            ->pluck('products');
        return $this->showAll($seller);
    }
}
