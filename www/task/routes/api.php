<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

        Route::prefix('product')->group(function () {
            Route::get('/',              [ProductController::class, 'index'  ]);//get-all
            Route::post('/',             [ProductController::class, 'store'  ]);//insert +
            Route::get('/{product}',     [ProductController::class, 'show'   ]);//get-one
            Route::put('/{product}',     [ProductController::class, 'update' ]);//
            Route::delete('/{product}',  [ProductController::class, 'destroy']);
        });

        Route::prefix('category')->middleware('checkAdmin')->group(function () {
            Route::get('/',               [CategoryController::class, 'index'  ]);
            Route::post('/',              [CategoryController::class, 'store'  ]);
            Route::get('/{category}',     [CategoryController::class, 'show'   ]);
            Route::put('/{category}',     [CategoryController::class, 'update' ]);
            Route::delete('/{category}',  [CategoryController::class, 'destroy']);
        });
//    Реализовать добавление в корзину и удаление
    Route::prefix('cart')->group(function () {
            Route::get('/add',    [CartController::class, 'addItemToCart'      ])->name('cart.add');
            Route::get('/remove', [CartController::class, 'removeItemFromCart' ])->name('cart.remove');
    });
});
