<?php

namespace App\Traits;

use App\Mail\UserCreated;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

trait ApiResponser
{

    /**
     * function to return success response API
     */
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    /**
     * function to return error response API
     */
    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    /**
     * function to return all response API
     */
    protected function showAll(Collection $collection, $code = 200)
    {

        return $this->successResponse(['data' => $collection], $code);
    }

    /**
     * function to return one response API
     */
    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse(['data' => $instance], $code);
    }

    /**
     * function to return success message
     */
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    /**
     * function to return resource 
     */
    protected function returnResource($instance, $data)
    {

        if (request()->has('sort_by')) {
            $attribute = $instance::originalAttribute(request()->sort_by);
            $data = $data->sortBy->{$attribute};
        }

        foreach (request()->query() as $query => $value) {
            $attribute = $instance::originalAttribute($query);
            if (isset($attribute, $value)) {
                $data = $data->where($attribute, $value);
            }
        }
        return $instance::collection($data);
    }
}
