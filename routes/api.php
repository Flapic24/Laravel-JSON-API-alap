<?php

use Illuminate\Support\Facades\Route;

Route::get('/_health', function () {
    return response()->json([
        'ok' => true,
    ]);
});