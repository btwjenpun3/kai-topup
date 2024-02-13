<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Private\Dashboard\DashboardContoller;
use App\Http\Controllers\Private\DataTable\DataTableController;
use App\Http\Controllers\Private\Flashsale\FlashsaleController;
use App\Http\Controllers\Private\Invoice\InvoiceRealmController;
use App\Http\Controllers\Private\ListGames\ListGamesController;
use App\Http\Controllers\Private\ListGames\SetHargaController;
use App\Http\Controllers\Private\Payment\PaymentController;
use App\Http\Controllers\Private\Product\ProductController;
use App\Http\Controllers\Private\Profile\ProfileController;
use App\Http\Controllers\Private\Recharge\RechargeController;
use App\Http\Controllers\Private\Report\ProfitReportController;
use App\Http\Controllers\Private\Reseller\ResellerSaldoController;
use App\Http\Controllers\Private\TopUp\PrivateTopUpController;
use App\Http\Controllers\Private\Transaction\TransactionController;
use App\Http\Controllers\Private\User\UserController;
use App\Http\Controllers\Public\AboutUs\AboutUsController;
use App\Http\Controllers\Public\Harga\HargaController;
use App\Http\Controllers\Public\Home\HomeController;
use App\Http\Controllers\Public\Invoice\InvoiceController;
use App\Http\Controllers\Public\Pencarian\PencarianController;
use App\Http\Controllers\Public\Simulate\SimulateController;
use App\Http\Controllers\Public\TopUp\TopUpController;
use App\Models\Flashsale;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Contracts\DataTable;

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

Route::prefix('/pencarian')
    ->name('pencarian.')
    ->controller(PencarianController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/topup')
    ->name('topup.')
    ->controller(TopUpController::class)
    ->group(function () {
        Route::get('/{slug}', 'index')->name('index');
        Route::post('/{slug}/process', 'process')->name('process');
    });

Route::prefix('/harga')
    ->name('lihat.harga.')
    ->controller(HargaController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/invoice')
    ->name('invoice.')
    ->controller(InvoiceController::class)
    ->group(function () {
        Route::get('/{id}', 'index')->name('index');
        Route::get('/status/{id}', 'statusPembayaran')->name('status');
    });

Route::prefix('/tentang-kami')
    ->name('about.')
    ->controller(AboutUsController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });


/**
 * Private Route Start Here
 */

Route::prefix('/realm/auth')
    ->name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('guest');
        Route::get('/daftar', 'register')->name('register')->middleware('guest');
        Route::post('/daftar', 'registerProcess')->name('register.process')->middleware('guest');
        Route::get('/daftar/google', 'redirectToGoogle')->name('register.google')->middleware('guest');
        Route::get('/daftar/google/callback', 'handleGoogleCallback');
        Route::post('/', 'auth')->name('process')->middleware('guest');
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/privacy-policy', 'privacy')->name('privacy');
    });

Route::prefix('/realm/dashboard')
    ->name('dashboard.')
    ->controller(DashboardContoller::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/realm/recharge')
    ->name('recharge.')
    ->controller(RechargeController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/result/{id}', 'indexResult')->name('index.result');
        Route::post('/', 'proses')->name('proses');
    });

Route::prefix('/realm/products')
    ->name('product.')
    ->controller(ProductController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/realm/list-games')
    ->name('games.')
    ->controller(ListGamesController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

Route::prefix('/realm/set-harga')
    ->name('harga.')
    ->controller(SetHargaController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/{id}', 'index')->name('index');
        Route::post('/{id}', 'store')->name('store');
        Route::post('/import/{id}', 'import');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/update/{gameId}/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

Route::prefix('/realm/topup')
    ->name('realm.topup.')
    ->controller(PrivateTopUpController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/{slug}', 'index')->name('index');
        Route::post('/process', 'process')->name('process');
        Route::get('/fill/{id}', 'fill');
    });    


Route::prefix('/realm/invoice')
    ->name('invoice.realm.')
    ->controller(InvoiceRealmController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/web', 'index')->name('index');
        Route::get('/admin', 'admin')->name('admin');
        Route::get('/reseller', 'reseller')->name('reseller');
        Route::get('/show/{id}', 'show');
    });

Route::prefix('/realm/transaksi')
    ->name('transaksi.')
    ->controller(TransactionController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

Route::prefix('/realm/payment')
    ->name('payment.')
    ->controller(PaymentController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/update/{id}', 'update')->name('update');
    });

Route::prefix('/realm/flashsale')
    ->name('flashsale.')
    ->controller(FlashsaleController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::post('/expired', 'storeExpired')->name('expired');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });


Route::prefix('/realm/report')
    ->name('report.')
    ->controller(ProfitReportController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/profit', 'indexProfit')->name('index.profit');
        Route::get('/profit/generate', 'generateProfit')->name('generate.profit');
    });

Route::prefix('/realm/user')
    ->name('user.')
    ->controller(UserController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/show/{id}', 'show');
        Route::post('/tambah/{id}', 'tambahSaldo');
    });
    
Route::prefix('/realm/profile')
    ->name('profile.')
    ->controller(ProfileController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
        Route::post('/password', 'updatePassword')->name('update.password');
    }); 
    
Route::prefix('/realm/isi-saldo')
    ->name('isi.saldo.')
    ->controller(ResellerSaldoController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');        
    });  

Route::prefix('/realm/datatables')
    ->name('datatable.')
    ->controller(DataTableController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/invoice/web', 'invoiceWeb')->name('invoice.web'); 
        Route::get('/invoice/admin', 'invoiceAdmin')->name('invoice.admin');  
        Route::get('/invoice/reseller', 'invoiceReseller')->name('invoice.reseller');   
        Route::get('/user/reseller', 'userReseller')->name('user.reseller');     
    }); 

