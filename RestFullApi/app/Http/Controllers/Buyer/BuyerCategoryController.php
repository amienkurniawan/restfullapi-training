<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
