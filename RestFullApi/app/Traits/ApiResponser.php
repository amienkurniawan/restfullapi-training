<?php

namespace App\Traits;

use App\Mail\UserCreated;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

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
        // if ($collection->isEmpty()) {
        //     return $this->successResponse(['data' => $collection], $code);
        // }
        // $transformer = $collection->first()->transformer;

        // $collection = $this->transformData($collection, $transformer);

        return $this->successResponse(['data' => $collection], $code);
    }

    /**
     * function to return one response API
     */
    protected function showOne(Model $instance, $code = 200)
    {
        // $transformer = $instance->transformer;
        // $instance = $this->transformData($instance, $transformer);

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
     * function to return fractal data 
     */
    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }
}
