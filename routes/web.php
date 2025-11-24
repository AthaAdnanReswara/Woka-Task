<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Auth Login 
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class,'formLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
//Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//prefik untuk admin
Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function() {
    Route::get('dashboard', [dashboardController::class,'login'])->name('dashboard');
});