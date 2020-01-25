<?php

namespace RestFullAPIAmien\Http\Controllers\Transaction;

use RestFullAPIAmien\Transaction;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Database\Eloquent\Collection;

class TransactionSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        return $this->showOne($transaction->products->seller);
    }
}
