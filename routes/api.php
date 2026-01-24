<?php
namespace Routes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PingController;
use App\Http\Controllers\Api\EchoController;

Route::get('/ping', PingController::class);

Route::post('/echo', EchoController::class);