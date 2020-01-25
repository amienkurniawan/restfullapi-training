<?php

namespace RestFullAPIAmien\Http\Controllers\Category;

use RestFullAPIAmien\Category;
use Illuminate\Http\Request;
use RestFullAPIAmien\Http\Controllers\Controller;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $category = $category->products;
        return $this->showAll($category);
    }
}
