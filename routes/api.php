<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeoServerProxyController;
use App\Http\Controllers\ChatbotController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/proxy-wms', [GeoServerProxyController::class, 'proxyWms']);
Route::get('/layer/legend', [GeoServerProxyController::class, 'getLegendGraphic']);
Route::post('/send-message', [ChatbotController::class, 'sendMessage'])->name('chat.sendMessage');
