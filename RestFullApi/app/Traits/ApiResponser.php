<?php

namespace App\Traits;

use App\Mail\UserCreated;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Pagination\LengthAwarePaginator;
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
    public function paginate(Collection $collection)
    {
        $perPage = env('LIMIT_DATA_PER_PAGE', 10);
        $page = LengthAwarePaginator::resolveCurrentPage();
        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        $paginated->appends(request()->all());

        return $paginated;
    }
}
