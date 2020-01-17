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
        // $categories = $transaction->products;
        // Log::info($transaction->products->categories);
        // return response()->json(['data' => $transaction->products()->categories]);
        // $data = Product::findOrFail(322);
        // return response()->json(['data' => $data->categories]);
        // $data = Transaction::findOrFail(3);
        return $this->showAll($transaction->products->categories);
    }
}
