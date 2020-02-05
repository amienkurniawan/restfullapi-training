<?php

namespace App\Traits;

use App\Mail\UserCreated;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Validator;

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
     * function to retur pagination
     */
    public function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];
        $messages = [
            'integer' => 'The :attribute field must have type integer',
            'max' => 'The :attribute field must have a maximum 50 length',
            'min' => 'The :attribute field must have a minimum 2 length',
            // 'in' => 'The :attribute must be one of the following types: ' . User::ADMIN_USER . ' : ' . User::REGULAR_USER,
        ];

        Validator::make(request()->all(), $rules, $messages);

        $perPage = env('LIMIT_DATA_PER_PAGE', 10);

        $page = LengthAwarePaginator::resolveCurrentPage();
        if (request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        }
        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        $paginated->appends(request()->all());

        return self::cacheResponseData($paginated);
    }

    /**
     * function to keep cache data response
     */
    protected function cacheResponseData($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30 / 60, function () use ($data) {
            return $data;
        });
    }
}
