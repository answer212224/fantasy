<?php

use App\Http\Controllers\Backend\WebHookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/hook', [WebHookController::class, 'store']);
