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
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blank', function () {
    return view('blank');
})->name('blank');

Route::middleware('auth')->group(function () {
    Route::resource('admin/user', UserController::class);
    Route::resource('admin/category', CategoryController::class);
    Route::resource('admin/product', ProductController::class);
    Route::resource('admin/branch', BranchController::class);
    Route::resource('admin/stock', StockController::class);
    Route::resource('admin/partner', PartnerController::class);
    Route::resource('admin/kurir', KurirController::class);
    Route::resource('admin/customer', CustomerController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
