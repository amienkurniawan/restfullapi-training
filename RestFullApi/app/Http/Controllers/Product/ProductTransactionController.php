<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $transaction = $product->transactions;
        return $this->showAll($transaction);
    }
}
