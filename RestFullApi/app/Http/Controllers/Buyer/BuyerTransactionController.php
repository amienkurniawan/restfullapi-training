<?php

namespace RestFullAPIAmien\Http\Controllers\Buyer;

use RestFullAPIAmien\Buyer;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class BuyerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $transaction = $buyer->transactions;
        return $this->showAll($transaction);
    }
}
