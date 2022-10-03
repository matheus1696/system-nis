<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Capacitacao\CapacitacaoController;
use App\Http\Controllers\Capacitacao\PalestranteController;
use App\Http\Controllers\Capacitacao\ServidorController;

//Liberação do Usuário CNEP Capacitacao CAN:capacitacao    
    
    Route::middleware('can:user_capacitacao')->group(function () {
        #Rota Capacitações
        Route::prefix('/cnep')->group(function (){
            Route::prefix('/qualifications')->group(function (){
                Route::resource('qualifications',CapacitacaoController::class);
    
                //Rotas Certificados
                    Route::get('/{qualification}/certificates',[CapacitacaoController::class,'certificate'])->name('certificates.index');
    
                //Rotas Palestrantes
                    Route::get('/{qualification}/speakers',[PalestranteController::class,'create'])->name('speakers.create');
                    Route::post('/{qualification}/speakers',[PalestranteController::class,'store'])->name('speakers.store');
                    Route::get('/speakers/{speaker}',[PalestranteController::class,'edit'])->name('speakers.edit');
                    Route::put('/speakers/{speaker}',[PalestranteController::class,'update'])->name('speakers.update');
                    Route::delete('/speakers/{speaker}',[PalestranteController::class,'destroy'])->name('speakers.destroy');
    
                //Rotas Servidores
                    Route::get('/{qualification}/servers',[ServidorController::class,'create'])->name('servers.create');
                    Route::post('/{qualification}/servers',[ServidorController::class,'store'])->name('servers.store');
                    Route::get('/servers/{server}',[ServidorController::class,'edit'])->name('servers.edit');
                    Route::put('/servers/{server}',[ServidorController::class,'update'])->name('servers.update');
                    Route::delete('/servers/{server}',[ServidorController::class,'destroy'])->name('servers.destroy');
            });
        });
    });
        



