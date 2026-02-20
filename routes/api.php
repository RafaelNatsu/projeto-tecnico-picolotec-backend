<?php

use App\Http\Controllers\EnumController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group( function () {
    Route::post('login','login');
});

// metadados
Route::prefix("meta")->controller(EnumController::class)->group(function (){
    Route::prefix('requisitions')->group(function (){
        Route::get('/priorities','priorityLevel');
        Route::get('/status','requisitionStatus');
    });
});

Route::middleware('auth:sanctum')->group(function () {

    # Autentication
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/me', [LoginController::class, 'me']);

    Route::middleware('role:admin|gerente')->controller(RoleController::class)->group(function (){
        Route::get('/role','index');
        Route::post('/role','assignRole');
        Route::delete('/role','removeRole');
    });

    Route::prefix('users')->
        middleware('role:admin|gerente')->
        controller(UserController::class)->group(function (){
        Route::get('/{id}','index');
        Route::post('/','store');
        Route::patch('/{id}','update');
        Route::delete('/{id}','delete');
    });

    Route::prefix('requisitions')->
        middleware('permission:create requesition|view requesition|edit requesition')->
        controller(RequisitionController::class)->group(function (){
        Route::get('/','listAll');
        Route::get('/{id}','index');
        Route::post('/','store');
        Route::patch('/{id}','update');
        Route::delete('/{id}','delete');
    });
});
