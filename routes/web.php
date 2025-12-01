<?php

use App\Http\Controllers\Admin\DeveloperController;
use App\Http\Controllers\Admin\pmController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\projectMemberController;
use App\Http\Controllers\Admin\taskCollaboratorController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PM\pengembangController;
use App\Models\taskCollaborator;
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
    //CRUD Project Member
    Route::resource('member', projectMemberController::class);
    //CRUD Task
    Route::resource('task', TaskController::class);
    //CRUD TaskColaborator
    Route::resource('collaborator', taskCollaboratorController::class);

});
//Prefik untuk PM
Route::prefix('PM')->name('PM.')->middleware(['auth','role:PM'])->group(function() {
    //tampilan dashboard
    Route::get('dashboard', [dashboardController::class,'login'])->name('dashboard');
    //tambah developer di PM
    Route::resource('pengembang', pengembangController::class);
    
});
//Prefik untuk Developer
Route::prefix('developer')->name('developer.')->middleware(['auth','role:developer'])->group(function() {
    //tampilan dashboard
    Route::get('dashboard', [dashboardController::class,'login'])->name('dashboard');
    
});