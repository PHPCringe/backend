<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\DonationTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\CollectiveController;
use App\Http\Controllers\CollectiveMemberController;
use App\Http\Controllers\TransactionExpenseController;
use App\Http\Controllers\TransactionDonationController;
use App\Http\Controllers\WalletController;

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

        Route::get('/email/verify', [AuthController::class, 'sendVerificationEmail'])
            ->middleware('auth:sanctum')
            ->name('verification.notice');

        Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmailAddress'])
            ->middleware('auth:sanctum')
            ->name('verification.verify');
    });

    // USER
    Route::get('/user/{user}', [UserController::class, 'profile']);

    // DISCOVER
    Route::get('/discover', [DiscoverController::class, 'discover']);

    // COLLECTIVES
    Route::get('collectives', [CollectiveController::class, 'index']);
    Route::post('collectives', [CollectiveController::class, 'store']);
    Route::get('collectives/{collective}', [CollectiveController::class, 'show']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('collectives/{collective}', [CollectiveController::class, 'destroy']);
    });
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

        Route::prefix('/members')->group(function () {
            Route::get('/', [CollectiveMemberController::class, 'index']);
            Route::post('/', [CollectiveMemberController::class, 'addMember']);
            Route::delete('/{member}', [CollectiveMemberController::class, 'removeMember']);
        });
    });

    Route::prefix('wallets')->group(function () {
        Route::post('/otp/{ewallet}', [WalletController::class, 'sendEWalletOTP'])
            ->middleware('auth:sanctum');
        Route::post('/register', [WalletController::class, 'registerWallet'])
            ->middleware('auth:sanctum');
    });
});
