<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');

Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('task.show');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('task.destroy');


Route::get('/index', [ProductController::class, 'index'])->name('product.index');
//Route::get('/detail/{prouct_master_id}/{product_id}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/detail/{prouct_master_id}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');

Route::post('/user/input', [UserController::class, 'input'])->name('user.input');