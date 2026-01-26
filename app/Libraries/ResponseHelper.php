<?php

if (!function_exists('sendResponse')) {
    function sendResponse($result, $message, $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ], $statusCode);
    }
}

if (!function_exists('sendError')) {
    function sendError($message, $errorMessages = [], $statusCode = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('sendException')) {
    function sendException($exception, $statusCode = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $exception->getMessage(),
            'trace'   => config('app.debug') ? $exception->getTrace() : null, // Only show trace in debug mode
        ], $statusCode);
    }
}
