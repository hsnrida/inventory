<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
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

Route::middleware([])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::middleware('auth:api')->prefix("products")->group(function () {
    Route::get('', [ProductController::class, 'all']);
    Route::post('', [ProductController::class, 'store']);
    Route::put('{product}', [ProductController::class, 'edit']);
    Route::delete('{product}', [ProductController::class, 'delete']);
    Route::get('{product}/items', [ItemController::class, 'all']);
    Route::post('{product}/items', [ItemController::class, 'store']);
    Route::put('{product}/items/{item}/sold', [ItemController::class, 'sold']);
    Route::delete('{product}/items/{item}', [ItemController::class, 'delete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
