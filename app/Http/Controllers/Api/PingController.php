<?php
namespace App\Http\Controllers\Api;
use App\Support\ApiResponse;

final class PingController{
    public function __invoke() {
        return ApiResponse::success("pong");
    }
}