<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

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
        return $next($request);
    }
}
