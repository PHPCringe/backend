<?php

use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\DonationTransactionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // AUTH
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
    });

    Route::get('/user/{user}', [AuthController::class, 'profile']);

    Route::get('/discover', [DiscoverController::class, 'discover']);

    Route::resource('collectives', CollectiveController::class);
    Route::prefix('collectives/{collective}')->group(function () {
        Route::get('/donate', [CollectiveController::class, 'donate']);

        Route::get('/available-payments', [CollectiveController::class, 'available_payments']);

        Route::group(['prefix' => 'donations'], function () {
            Route::get('/{donation}', [TransactionDonationController::class, 'show']);
            Route::post('/', [TransactionDonationController::class, 'store'])->middleware('auth:sanctum');
        });

        Route::group(['prefix' => 'expenses'], function () {
            Route::get('/{expense}', [TransactionExpenseController::class, 'show']);
            Route::post('/', [TransactionExpenseController::class, 'store'])->middleware('auth:sanctum');
        });
    });
});
