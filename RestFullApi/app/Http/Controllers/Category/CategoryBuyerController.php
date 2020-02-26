<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryBuyerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * display a listing resources
     * 
     * @return \Illumninate\Http\Response
     */
    public function index(Category $category)
    {
        $this->adminAuthorized();
        $buyers = $category->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();
        return $this->showAll($buyers);
    }
}
