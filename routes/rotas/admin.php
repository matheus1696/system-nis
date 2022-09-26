<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;

//Liberação para o Usuário Administrador CAN:admin
    Route::middleware('can:admin')->group(function () {
        #Prefixo /admin
            Route::prefix('admin')->group(function (){

                #Prefixo /user
                Route::prefix('user')->group(function (){

                    #Rota de Gerenciamento de Contas de Usuários
                        Route::resource('account', UserController::class);
                        Route::post('account/{account}/access', [UserController::class, 'access'])->name('account.access');
                });
            });
    });



