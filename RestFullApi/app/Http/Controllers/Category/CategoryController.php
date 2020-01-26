<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        $messages = [
            'required' => 'The :attribute field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),  403);
        }

        $newCategory = Category::create($request->all());

        return $this->showOne($newCategory, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        $messages = [
            'required' => 'The :attribute field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),  403);
        }

        $category->fill($request->intersect(['name', 'description']));
        if ($category->isClean()) {
            return $this->errorResponse('you need specify diffrent value', 422);
        }
        $category->save();
        return $this->showOne($category, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
