<?php

namespace RestFullAPIAmien\Http\Controllers\Seller;

use RestFullAPIAmien\Seller;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class SellerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $category = $seller->products()
            ->whereHas('categories')
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique('id')
            ->values();
        return $this->showAll($category);
    }
}
