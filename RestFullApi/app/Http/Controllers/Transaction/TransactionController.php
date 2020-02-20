<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        foreach (request()->query() as $query => $value) {
            $attribute = TransactionResource::originalAttribute($query);
            if (isset($attribute, $value)) {
                $transactions = $transactions->where($attribute, $value);
            }
        }
        if (request()->has('sort_by')) {
            $attribute = TransactionResource::originalAttribute(request()->sort_by);
            $transactions = $transactions->sortBy->{$attribute};
        }
        $transactions = self::paginate($transactions);
        return TransactionResource::collection($transactions)->values();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }
}
