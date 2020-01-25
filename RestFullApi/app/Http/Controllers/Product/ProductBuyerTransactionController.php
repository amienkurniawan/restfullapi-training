<?php

namespace RestFullAPIAmien\Http\Controllers\Product;

use RestFullAPIAmien\Product;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;
use RestFullAPIAmien\Transaction;
use RestFullAPIAmien\User;
use Illuminate\Support\Facades\DB;
use Validator;

class ProductBuyerTransactionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'integer' => 'The :attribute field must integer.',
            'min' => 'The :attribute field must minimum 1.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),  403);
        }

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('The Buyer must be diffrent from seller', 409);
        }

        if ($buyer->isVerified() == "0") {
            return $this->errorResponse('the buyer must verified User', 409);
        }

        if ($product->seller->isVerified() == "0") {
            return $this->errorResponse('The Seller must Verified User', 409);
        }

        if (!$product->isAvailable()) {
            return $this->errorResponse('The Product must Available', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('The Product Quantity does not enough for this transaction', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'products_id' => $product->id
            ]);

            return $this->showOne($transaction, 201);
        });
    }
}
