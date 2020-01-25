<?php

namespace RestFullAPIAmien\Http\Controllers\Category;

use RestFullAPIAmien\Category;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class CategoryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $transaction = $category->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values();
        return $this->showAll($transaction);
    }
}
