<?php

use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\pmController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
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
    //tampilan dashboard
    Route::get('dashboard', [dashboardController::class,'login'])->name('dashboard');
    //CRUD PM
    Route::resource('PM', pmController::class);
    //CURD developer
    Route::resource('developer', DeveloperController::class);
    //CRUD Project
    Route::resource('project', ProjectController::class);
    //CRUD Task
    Route::resource('task', TaskController::class);
});
//Prefik untuk PM
Route::prefix('PM')->name('PM.')->middleware(['auth','role:PM'])->group(function() {
    //tampilan dashboard
    Route::get('dashboard', [dashboardController::class,'login'])->name('dashboard');
    
});