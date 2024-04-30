<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::group(['middleware' => 'jwt.auth'], function () {
    Route::resource('users', UserController::class); 
    Route::post('users/{id}', [UserController::class, 'update']);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    Route::post('books/{id}', [BookController::class, 'update']);
    Route::resource('roles', RoleController::class); 
Route::resource('clients', ClientController::class); 
Route::resource('orders', OrderController::class); 
});

