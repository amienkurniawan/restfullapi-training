<?php

namespace RestFullAPIAmien\Http\Controllers\Transaction;

use RestFullAPIAmien\Transaction;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \RestFullAPIAmien\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }
}
