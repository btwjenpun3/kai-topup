<?php

use App\Http\Controllers\Private\Dashboard\DashboardContoller;
use App\Http\Controllers\Private\Invoice\InvoiceRealmController;
use App\Http\Controllers\Private\ListGames\ListGamesController;
use App\Http\Controllers\Private\ListGames\SetHargaController;
use App\Http\Controllers\Private\Payment\PaymentController;
use App\Http\Controllers\Private\Testing\TestingController;
use App\Http\Controllers\Public\Home\HomeController;
use App\Http\Controllers\Public\Invoice\InvoiceController;
use App\Http\Controllers\Public\TopUp\TopUpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


/**
 * Public Route Start Here
 */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/topup')
    ->name('topup.')
    ->controller(TopUpController::class)
    ->group(function () {
        Route::get('/{slug}', 'index')->name('index');
        Route::post('/{slug}/process', 'process')->name('process');
    });

Route::prefix('/invoice')
    ->name('invoice.')
    ->controller(InvoiceController::class)
    ->group(function () {
        Route::get('/{id}', 'index')->name('index');
        Route::get('/status/{id}', 'statusPembayaran')->name('status');
    });

/**
 * Private Route Start Here
 */

Route::prefix('/realm')
    ->name('dashboard.')
    ->controller(DashboardContoller::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/realm/list-games')
    ->name('games.')
    ->controller(ListGamesController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

Route::prefix('/realm/set-harga')
    ->name('harga.')
    ->controller(SetHargaController::class)
    ->group(function () {
        Route::get('/{id}', 'index')->name('index');
        Route::post('/{id}', 'store')->name('store');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/update/{gameId}/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });


Route::prefix('/realm/invoice')
    ->name('invoice.realm.')
    ->controller(InvoiceRealmController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/realm/payment')
    ->name('payment.')
    ->controller(PaymentController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/realm/testing')
    ->name('testing.')
    ->controller(TestingController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/shopeepay', 'testShopeePay')->name('shopeePay');
    });   