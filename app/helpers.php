<?php

if (!function_exists('successResponse')) {
    function successResponse($data = null, $message = 'عملیات موفق بود.', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($message = 'خطا رخ داد.', $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}
