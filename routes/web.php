<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ManTyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the 'web' middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::prefix('product')->group(function() {
    Route::controller(ProductController::class)->group(function() {
        Route::get('/', 'index')->name('product.index');
        Route::post('/create', 'create')->name('product.create');
        Route::post('/update/{id}', 'update')->name('product.update');
        Route::delete('/delete/{id}', 'delete')->name('product.delete');
    });
});

Route::prefix('type-manufacturer')->group(function() {
    Route::controller(ManTyController::class)->group(function() {
        Route::get('/', 'index')->name('manty.index');
        Route::post('/create', 'create')->name('manty.create');
        Route::post('/update/{id}', 'update')->name('manty.update');
        Route::delete('/delete/{id}', 'delete')->name('manty.delete');
    });
});
