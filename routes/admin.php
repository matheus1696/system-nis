<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;

//Liberação para Super Usuário CAN:super_adm
    Route::middleware('super_adm')->group(function () {

    });

//Liberação para o Usuário Administrador CAN:admin
    Route::middleware('can:admin')->group(function () {
        #Rota com Prefixo /admin
            Route::prefix('admin')->group(function (){
                #Rota com Prefixo /user
                    Route::prefix('user')->group(function (){
                        Route::resource('account', UserController::class);
                        Route::post('account/{account}/access', [UserController::class, 'access'])->name('account.access');
                    });
                #Rota Dashboard
                    Route::resource('dashboard', AdminDashboardController::class);
            });
    });



