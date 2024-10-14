<?php

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
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

Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('login.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        $date = date('Y') . "-" . date('m') ."-01 00:00:00";
        $ordersAll = Order::all();
        $ordersMonthly = Order::where('created_at', '>', $date)->get();
        $totalAll = 0;
        $totalMonthly = 0;

        foreach($ordersAll as $order) {
            $totalAll += $order->total;
        }

        foreach($ordersMonthly as $order) {
            $totalMonthly += $order->total;
        }

        $context = [
            'totalAll' => $totalAll,
            'totalMonthly' => $totalMonthly,
            'totalOrderDetail' => OrderDetail::all(),
            'totalProduct' => Product::all(),
        ];
        return view('index', $context);
    })->name('index');

    Route::prefix('customer')->group(function() {
        Route::controller(CustomerController::class)->group(function() {
            Route::get('/', 'index')->name('customer.index');
            Route::post('/create', 'create')->name('customer.create');
            Route::post('/update/{id}', 'update')->name('customer.update');
            Route::delete('/delete/{id}', 'delete')->name('customer.delete');
        });
    });

    Route::prefix('order')->group(function() {
        Route::controller(OrderController::class)->group(function() {
            Route::get('/', 'index')->name('order.index');
            Route::get('/pdf', 'pdf')->name('order.pdf');
            Route::post('/create', 'create')->name('order.create');
            Route::post('/update/{id}', 'update')->name('order.update');
            Route::delete('/delete/{id}', 'delete')->name('order.delete');
        });
    });

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
});
