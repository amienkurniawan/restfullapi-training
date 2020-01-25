<?php

namespace RestFullAPIAmien\Http\Controllers\Seller;

use RestFullAPIAmien\Seller;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class SellerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();
        return $this->showAll($transactions);
    }
}
