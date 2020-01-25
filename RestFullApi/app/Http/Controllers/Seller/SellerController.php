<?php

namespace RestFullAPIAmien\Http\Controllers\Seller;

use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;
use RestFullAPIAmien\Seller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::with('products')->get();
        return $this->showAll($sellers, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $sellers)
    {
        return $this->showOne($sellers, 200);
    }
}
