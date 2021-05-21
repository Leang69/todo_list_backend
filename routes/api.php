<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::POST('/register',[\App\Http\Controllers\AuthController::class,'register'])->name('register');
Route::POST('/login',[\App\Http\Controllers\AuthController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group(function(){
    Route::GET('/user',[\App\Http\Controllers\AuthController::class,'user'])->name('user');
    Route::GET('/logout',[\App\Http\Controllers\AuthController::class,'logout'])->name('logout');

    Route::GET('/task_show',[\App\Http\Controllers\TaskController::class,'show'])->name("task.show");
    Route::GET('/task_delete',[\App\Http\Controllers\TaskController::class,'delete'])->name("task.delete");
    Route::POST('/task_update',[\App\Http\Controllers\TaskController::class,'update'])->name("task.update");
    Route::POST('/task_create',[\App\Http\Controllers\TaskController::class,'create'])->name("task.create");
});
