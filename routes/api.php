<?php

use App\Http\Controllers\Api\ExpenceController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\ImportController;
    use App\Http\Controllers\Api\InvestorController;
    use App\Http\Controllers\Api\ProductController;
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

    /**
     * -----------------------------
     * Authenticated user routes
     * ------------------------------
     */
    Route::group(['middleware' => 'auth:api'], function() {
        Route::apiResource('/investors', InvestorController::class);

        Route::post('/expences', [ExpenceController::class, 'store'])->name('expences.store');
        Route::get('/expences', [ExpenceController::class, 'index'])->name('expences.get');
        Route::post('/expences/{expence}', [ExpenceController::class, 'update'])->name('expences.update');
        Route::delete('/expences/{expence}', [ExpenceController::class, 'destroy'])->name('expences.delete');

        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products', [ProductController::class, 'index'])->name('products.get');
        Route::post('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');

        Route::get('/imports', [ImportController::class, 'index']);

        Route::get('/exports', [ExportController::class, 'index']);
        Route::post('/exports', [ExportController::class, 'store']);
    });
