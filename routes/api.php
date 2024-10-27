<?php

use App\Http\Controllers\Api\Login;
use App\Http\Controllers\Api\Playlist;
use App\Http\Controllers\Api\RefreshAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GetAccessToken;

Route::post('login',[Login::class, 'login']);
Route::post('/get_access_token', [GetAccessToken::class, 'getToken']);
Route::post('/refresh_access_token', [RefreshAccessToken::class, 'refreshAccessToken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('playlist/all', [Playlist::class, 'index']);
    Route::post('playlist/single', [Playlist::class, 'show']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
