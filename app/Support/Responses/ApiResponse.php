<?php
namespace App\Support\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(string $message = '', array $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error(string $message = '', array $errors = [], int $code = 422): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    public static function validationError(array $errors, string $message = 'خطای اعتبارسنجی'): JsonResponse
    {
        return self::error($message, $errors, 422);
    }

    public static function notFound(string $message = 'یافت نشد'): JsonResponse
    {
        return self::error($message, [], 404);
    }

    public static function serverError(string $message = 'خطای سرور'): JsonResponse
    {
        return self::error($message, [], 500);
    }
}
