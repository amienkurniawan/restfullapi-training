<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\BuyerResource;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyer = Buyer::with('transactions')->get();
        foreach (request()->query() as $query => $value) {
            $attribute = BuyerResource::originalAttribute($query);
            if (isset($attribute, $value)) {
                $buyer = $buyer->where($attribute, $value);
            }
        }
        if (request()->has('sort_by')) {
            $attribute = BuyerResource::originalAttribute(request()->sort_by);
            $buyer = $buyer->sortBy($attribute);
        }
        Log::debug($buyer);
        $buyer = $this->paginate($buyer);
        return BuyerResource::collection($buyer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        // $buyer = Buyer::with('transactions')->findOrFail($id);
        return new BuyerResource($buyer);
    }
}
