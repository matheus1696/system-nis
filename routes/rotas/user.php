<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\Profile\ProfileController;

//Liberação para o Usuário Administrador CAN:admin
Route::middleware('can:admin')->group(function () {
    #Prefixo /admin
        Route::prefix('config')->group(function (){

            #Prefixo /user
            Route::prefix('user')->group(function (){

                #Rota de Gerenciamento de Contas de Usuários
                    Route::resource('account', UserController::class);
                    Route::post('account/{account}/access', [UserController::class, 'access'])->name('account.access');
            });
        });
});

//Liberação do Usuário Comum CAN:user
    Route::middleware('can:user')->group(function () {
        #Rota com Prefixo /profile
            Route::prefix('profile')->group(function (){
                #Rota com Prefixo /account
                    Route::prefix('account')->group(function (){
                        Route::resource('profile', ProfileController::class);
                    });
            });
    });



