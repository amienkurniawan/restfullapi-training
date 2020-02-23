<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Scopes\SellerScopes;
use App\Seller;

class SellerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
        $this->middleware('can:view,seller')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::with('products')->get();
        foreach (request()->query() as $query => $value) {
            $attribute = SellerResource::originalAttribute($query);
            if (isset($attribute, $value)) {
                $sellers = $sellers->where($attribute, $value);
            }
        }
        if (request()->has('sort_by')) {
            $attribute = SellerResource::originalAttribute(request()->sort_by);
            $sellers = $sellers->sortBy->{$attribute};
        }
        $sellers = self::paginate($sellers);
        return SellerResource::collection($sellers)->values();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $sellers)
    {
        return new SellerResource($sellers);
    }
}
