<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\Logging\Log;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        return $this->showAll($transaction->products->categories);
    }
}
