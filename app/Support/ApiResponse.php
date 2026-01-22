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

}