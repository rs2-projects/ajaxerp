<?php



use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
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


Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');

    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('forgot-password', [ForgotPasswordController::class, 'submitForgotPassword'])->name('forgot-password');
    Route::get('verify-identity', [ForgotPasswordController::class, 'showForgotPasswordIdentity'])->name('verify-identity');
    Route::post('verify-identity', [ForgotPasswordController::class, 'submitForgotPasswordIdentity'])->name('verify-identity');
    Route::get('reset-password', [ResetPasswordController::class, 'showResetPassword'])->name('reset-password');
    Route::post('reset-password', [ResetPasswordController::class, 'submitResetPassword'])->name('reset-password');
});

Route::group(['middleware' => 'auth'], function () {

    //bot route start
    /*Route::get('chart-of-accounts', [BotController::class,'chartOfAccounts']);*/
    //bot route end

    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');

    // dashboard route start
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('home', [DashboardController::class, 'showDashboard'])->name('home');
    // dashboard route end

    include "web-includes/settings.php";

    include "web-includes/hr.php";

    include "web-includes/inventory.php";

    include "web-includes/procurement.php";

    include "web-includes/accounting.php";

    include "web-includes/employee.php";

    include "web-includes/sales.php";

    include "web-includes/production.php";

    include "web-includes/showroom.php";

    include "web-includes/report.php";

});
