<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Config\BlocoController;

//Liberação para o Usuário Administrador CAN:admin
    Route::middleware('can:admin')->group(function () {

        #Prefixo /config
            Route::prefix('config')->group(function (){
                    
            });
    });




