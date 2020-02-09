<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Contracts\Logging\Log;
use Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transformInput:' . CategoryResource::class)->only(['store', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        foreach (request()->query() as $query => $value) {
            $attribute = CategoryResource::originalAttribute($query);
            if (isset($attribute, $value)) {
                $categories = $categories->data->where($attribute, $value);
            }
        }
        if (request()->has('sort_by')) {
            $attribute = CategoryResource::originalAttribute(request()->sort_by);
            $categories = $categories->sortBy($attribute)->values();
        }
        $categories = self::paginate($categories);
        return CategoryResource::collection($categories);
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

        $this->validate($request, $rules, $messages);

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
        return new CategoryResource($category);
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
