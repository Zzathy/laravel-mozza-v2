<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix("product")->group(function() {
    Route::controller(ProductController::class)->group(function() {
        Route::get('/', 'index')->name('admin.product.index');
        Route::post('/create', 'create')->name('admin.product.create');
        Route::post('/update/{id}', 'update')->name('admin.product.update');
        Route::delete('delete/{id}', 'delete')->name('admin.product.delete');
    });
});
