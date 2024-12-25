<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\OrderController;

// web.php (Routes)

Route::get('/', [LaundryController::class, 'home'])->name('home');
Route::get('/contact', [LaundryController::class, 'contact'])->name('contact');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/order', [OrderController::class, 'create'])->name('orders.create');
Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
Route::get('/show', [LaundryController::class, 'show'])->name('orderId');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/order-history', [OrderController::class, 'index'])->name('orders.history');
Route::get('/admin/order-list', [AdminOrderController::class, 'index'])->name('admin.orders');
Route::post('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
Route::post('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
