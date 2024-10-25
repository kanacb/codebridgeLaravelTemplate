<?php

namespace App\Traits;

use Illuminate\Http\ResponseTrait as ParentResponseTraits;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Utils\Constants;
use App\Models\Exception as ExceptionModel;

trait ResponseTraits
{
    use ParentResponseTraits;

    public function successResponse($data, $message)
    {
        return response()->json(
            [
                'skip' => 0,
                'limit' => 100,
                'total' => count($data),
                'data' => $data,
            ],
            Constants::$ERROR_CODE['success']
        );
    }

    public function validationErrorResponse(ValidationException $exception, $className, $functionName, $line)
    {
        $id = Auth::user() ? Auth::user()->id : 0;
        if($id>0){
            ExceptionModel::create(
                ['user_id' => $id,
                "type" => 'ValidationException',
                "function" => $functionName,
                "class" => $className,
                "line" => $line,
                "exception" => $exception->getMessage(),
                "trace" => $exception->getTraceAsString()
                ]
            );
        }

        return response()->json(
            [
                'statusCode' => 400,
                'status' => false,
                'type' => 'ValidationException',
                'class' => $className,
                'function' => $functionName,
                'line' => $line,
                'data' => null,
                'error' => ['exception' => $exception->getMessage(),"trace" => ""],
            ],
            Constants::$ERROR_CODE['internal_server_error']
        );
    }

    public function exceptionErrorResponse(\Exception $exception, $className, $functionName, $line, $step = '')
    {
        $id = isset(Auth::user()->id) ? Auth::user()->id : 0;
        if($id>0){
            ExceptionModel::create(
                ['user_id' => $id,
                "type" => 'Exception',
                "function" => $functionName,
                "class" => $className,
                "line" => $line,
                "exception" => $exception->getMessage(),
                "trace" => $exception->getTraceAsString()
                ]
            );
        }

        $code = (int) $exception->getCode();
        return response()->json(
            [
                'id' => $id,
                'statusCode' => 400,
                'status' => false,
                'type' => 'Exception',
                'class' => $className,
                'function' => $functionName,
                'line' => $line,
                'data' => null,
                'error' => ['exception' => $exception->getMessage(), "trace" => ""],
                "message" => $step
            ],
            Constants::$ERROR_CODE['internal_server_error']
        );
    }
}