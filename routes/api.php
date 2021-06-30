<?php

use App\Http\Controllers\Api\V1;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:sanctum']],function () {
    Route::post('logout',[AuthController::class,'logout'])->name('auth.logout');
    
    Route::prefix('v1')->name('v1.')->group(function() {
        Route::get('category',[V1\CategoryController::class,'index'])->name('category.index');
        Route::post('category',[V1\CategoryController::class,'store'])->name('category.store');
        Route::get('category/{id}',[V1\CategoryController::class,'show'])->name('category.show');
        Route::put('category/{id}',[V1\CategoryController::class,'update'])->name('category.update');
        Route::patch('category/{id}',[V1\CategoryController::class,'update'])->name('category.update');
        Route::delete('category/{id}',[V1\CategoryController::class,'destroy'])->name('category.destroy');

        Route::get('product',[V1\ProductController::class,'index'])->name('product.index');
        Route::post('product',[V1\ProductController::class,'store'])->name('product.store');
        Route::get('product/{id}',[V1\ProductController::class,'show'])->name('product.show');
        Route::put('product/{id}',[V1\ProductController::class,'update'])->name('product.update');
        Route::patch('product/{id}',[V1\ProductController::class,'update'])->name('product.update');
        Route::delete('product/{id}',[V1\ProductController::class,'destroy'])->name('product.destroy');
    });  
});

Route::post('register',[AuthController::class,'register'])->name('auth.register');
Route::post('login',[AuthController::class,'login'])->name('auth.login');