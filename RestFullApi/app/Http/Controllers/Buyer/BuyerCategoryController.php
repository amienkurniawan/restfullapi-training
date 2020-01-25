<?php

namespace RestFullAPIAmien\Http\Controllers\Buyer;

use RestFullAPIAmien\Buyer;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class BuyerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()->with('products.categories')
            ->get()
            ->pluck('products.categories')
            ->unique('id')
            ->collapse();
        return $this->showAll($categories);
    }
}
