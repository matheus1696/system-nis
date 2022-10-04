<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Config\UnidadeController;

//Liberação para o Usuário Administrador CAN:admin
    Route::middleware('can:admin')->group(function () {

        #Prefixo /config
            Route::prefix('config')->group(function (){
                #Rota Admin Dashboard
                    Route::resource('unidade', UnidadeController::class);  
            });
    });




