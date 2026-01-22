<?php
namespace App\Support;

final class ApiResponse {
    public static function success(mixed $data = null, array $meta = [], int $status = 200) {
        $baseMeta = [
            'timestamp' => now()->toIso8601String(),
        ];


        return response()->json([
            'ok' => true,
            'data' => $data,
            'meta' => array_merge($baseMeta, $meta),
        ], $status);
    }

    public static function error(string $code, string $message, mixed $details = null, array $meta = [], int $status = 400) {
        $baseMeta = [
            'timestamp' => now()->toIso8601String(),
        ];

        return response()->json([
            'ok' => false,
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details,
            ],
            'meta' => array_merge($baseMeta, $meta),
        ], $status);
    }
}