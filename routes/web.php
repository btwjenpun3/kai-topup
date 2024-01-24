<?php

use App\Http\Controllers\Private\Dashboard\DashboardContoller;
use App\Http\Controllers\Private\ListGames\ListGamesController;
use App\Http\Controllers\Private\ListGames\SetHargaController;
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
    });

/**
 * Private Route Start Here
 */

Route::prefix('/dashboard')
    ->name('dashboard.')
    ->controller(DashboardContoller::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/list-games')
    ->name('games.')
    ->controller(ListGamesController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

Route::prefix('/set-harga')
    ->name('harga.')
    ->controller(SetHargaController::class)
    ->group(function () {
        Route::get('/{id}', 'index')->name('index');
        Route::post('/{id}', 'store')->name('store');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/update/{gameId}/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });