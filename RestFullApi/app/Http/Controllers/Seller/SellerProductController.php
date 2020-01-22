<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Seller $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];
        $this->validate($request, $rules);

        $data = $request->all();

        $data['status'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $products = Product::create($data);

        return $this->showOne($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'status' => 'in:' . Product::UNAVAILABLE_PRODUCT . ',' . Product::AVAILABLE_PRODUCT,
            'quantity' => 'integer|min:1',
            'image' => 'image',
        ];
        $this->validate($request, $rules);
        $this->checkSeller($seller, $product);
        $product->fill($request->only([
            'name',
            'description',
            'quantity',
        ]));

        if ($request->has('status')) {
            $product->status = $request->status;
            if ($product->isAvailable() && $product->categories()->count() == 0) {
                return $this->errorResponse('an active product must have at least one category ', 409);
            }
        }

        if ($product->isClean()) {
            return $this->errorResponse('you need to specify a different value to update', 422);
        }

        $data = $request->all();

        $product->save();
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);
        $product->delete();
        Storage::delete($product->image);
        return $this->showOne($product);
    }
    /**
     * to check if this product owned by seller
     * @param \App\Seller $seller
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    protected function checkSeller($seller, $product)
    {
        if ($seller->id != $product->seller_id) {
            throw new HttpException(422, 'the specified seller is not actual seller of the product');
        }
    }
}
