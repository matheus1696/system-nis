<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TI\ProcessoLicitatorio\ProcessoLicController;

//Liberação do Usuário TI  
    
    Route::middleware('can:user_ti')->group(function () {
        #Rota Capacitações
        Route::prefix('/ti')->group(function (){
            Route::prefix('/processos_lic')->group(function (){
                Route::resource('licitacao',ProcessoLicController::class);
                Route::post('/licitacao/{licitacao}/item',[ProcessoLicController::class,'createItem'])->name('licitacao.createItem');
            });
        });
    });
        

