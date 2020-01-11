<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Traits\ApiResponser;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // exception for validation
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }
        
        // exception fot model not found or data not found
        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("can find what you looking for in {$model}",404);
        }

        // exception for unAuthenticated request
        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request, $exception);
        }
        
        // exception for unAuthorize request
        if($exception instanceof AuthorizationException){
            return $this->errorResponse($exception->getMessage(),403);
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('Unauthenticated.',401);
    }

    /**
     * function to create a response from given validation exception
     * @param \Illuminate\Validation\ValidationException $e
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response 
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request){
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors,422);
    }
}
