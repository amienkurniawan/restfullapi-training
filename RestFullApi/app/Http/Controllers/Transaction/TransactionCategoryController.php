<?php

namespace RestFullAPIAmien\Http\Controllers\Transaction;

use RestFullAPIAmien\Transaction;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;
use RestFullAPIAmien\Product;
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
