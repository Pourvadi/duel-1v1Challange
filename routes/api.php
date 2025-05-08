<?php

use App\Http\Controllers\DuelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/duels/request', [DuelController::class, 'send']);
    Route::post('/duels/{id}/accept', [DuelController::class, 'accept']);
    Route::post('/duels/{id}/reject', [DuelController::class, 'reject']);
    Route::get('/duels/my-requests', [DuelController::class, 'list']);
});