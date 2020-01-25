<?php

namespace RestFullAPIAmien\Http\Controllers\Seller;

use RestFullAPIAmien\Seller;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class SellerBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $buyer = $seller->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')->values();

        return $this->showAll($buyer);
    }
}
