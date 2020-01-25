<?php

namespace RestFullAPIAmien\Http\Controllers\Category;

use RestFullAPIAmien\Category;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class CategorySellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $seller = $category->products()->with('seller')
            ->get()
            ->pluck('seller')
            ->unique()
            ->values();
        return $this->showAll($seller);
    }
}
