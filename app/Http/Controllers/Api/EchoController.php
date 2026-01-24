<?php
namespace App\Http\Controllers\Api;

use App\Support\ApiResponse;
use App\Http\Requests\EchoRequest;

final class EchoController {
    public function __invoke(EchoRequest $request)
    {
        $validated = $request->validated();

        return ApiResponse::success($validated);
    }
}
