<?php

namespace RestFullAPIAmien\Http\Controllers\Product;

use RestFullAPIAmien\Category;
use RestFullAPIAmien\Product;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories()->get();
        return $this->showAll($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \RestFullAPIAmien\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        // update category in product
        // syncWithoutDetaching => method to update with adding new not replace already exist
        // sync => method to update with replacing data
        // attach => method to update by added data already exist (can double data at same time)

        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \RestFullAPIAmien\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('This Category is not belong to the product', 404);
        }

        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }
}
