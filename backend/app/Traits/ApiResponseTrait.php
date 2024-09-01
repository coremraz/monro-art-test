<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data = null, $message = null, $code = 200)
    {
        $response = [
            'success' => true,
            'code' => $code,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    protected function errorResponse($message, $code = 400, $data = null)
    {
        $response = [
            'success' => false,
            'code' => $code,
            'message' => $message,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
