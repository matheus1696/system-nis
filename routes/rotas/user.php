<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Profile\ProfileController;

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



