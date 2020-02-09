<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $transform)
    {

        $transformInput = [];
        foreach ($request->request->all() as $input => $value) {
            $transformInput[$transform::originalAttribute($input)] = $value;
        }
        $request->replace($transformInput);
        $response = $next($request);
        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();
            $transformErrors = [];
            foreach ($data->error as $errorField => $errorMessage) {
                $transformField = $transform::transformedAttribute($errorField);
                $transformErrors[$transformField] = str_replace($errorField, $transformField, $errorMessage);
            }
            $data->error = $transformErrors;
            $response->setData($data);
        }

        return $response;
    }
}
