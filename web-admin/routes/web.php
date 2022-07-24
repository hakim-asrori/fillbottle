<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pengunjung.welcome');
});

// Route::get('/home', 'HomeController@index')->name('home');



Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('admin/user', UserController::class);
    Route::resource('admin/category', CategoryController::class);
    Route::resource('admin/product', ProductController::class);
    Route::resource('admin/branch', BranchController::class);
    Route::resource('admin/stock', StockController::class);
    Route::resource('admin/partner', PartnerController::class);
    Route::resource('admin/kurir', KurirController::class);
    Route::resource('admin/customer', CustomerController::class);
    Route::resource('admin/transaction', TransactionController::class);

    Route::get('/admin/cetak_product', 'CetakController@cetak_product')->name('cetak.product');
    Route::get('/admin/cetak_partner', 'CetakController@cetak_partner')->name('cetak.partner');
    Route::get('/admin/cetak_branch', 'CetakController@cetak_branch')->name('cetak.branch');
    Route::get('/admin/cetak_kurir', 'CetakController@cetak_kurir')->name('cetak.kurir');
    Route::get('/admin/cetak_customer', 'CetakController@cetak_customer')->name('cetak.customer');
    Route::get('/admin/cetak_stock', 'CetakController@cetak_stock')->name('cetak.stock');
    Route::get('/admin/cetak_transaction', 'CetakController@cetak_transaction')->name('cetak.transaction');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/blank', function () {
        return view('blank');
    })->name('blank');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth', 'is_admin']);
