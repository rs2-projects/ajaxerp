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

Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');


Route::get('/', [\App\Http\Controllers\Dashboard\DashboardController::class, 'showDashboard'])->name('dashboard');
Route::get('home', [\App\Http\Controllers\Dashboard\DashboardController::class, 'showDashboard'])->name('home');
