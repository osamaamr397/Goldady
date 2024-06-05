<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
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


   
Route::get('/test', function () {
    return response()->json(['message' => 'Hello World!'], 200);
});



Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/posts', [PostController::class, 'index']);
Route::middleware('auth:sanctum')->get('/posts/{id}', [PostController::class, 'show']);
Route::middleware('auth:sanctum')->post('/posts', [PostController::class, 'store']);
Route::middleware('auth:sanctum')->put('/posts/{id}', [PostController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/posts/{id}', [PostController::class, 'destroy']);
//Route::middleware('auth:sanctum')->get('/categories/{id}/posts', [PostController::class, 'getPostsByCategory']);
Route::middleware('auth:sanctum')->get('/categories/{id}/posts', [CategoryController::class, 'getPostsByCategory']);

Route::middleware('auth:sanctum')->get('/categories', [CategoryController::class, 'index']);
Route::middleware('auth:sanctum')->get('/categories/{id}', [CategoryController::class, 'show']);
Route::middleware('auth:sanctum')->post('/categories', [CategoryController::class, 'store']);
Route::middleware('auth:sanctum')->put('/categories/{id}', [CategoryController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/categories/{id}', [CategoryController::class, 'destroy']);
