<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\DashboardController;

//Liberação para o Usuário Administrador CAN:admin
    Route::middleware('can:admin_dashboard')->group(function () {

        #Prefixo /admin
            Route::prefix('admin')->group(function (){

                #Rota Admin Dashboard
                    Route::resource('dashboard', AdminDashboardController::class);
                    
            });
    });

//Liberação do Usuário Comum CAN:user
    Route::middleware('can:user_dashboard')->group(function () {
            
        #Rota User Dashboard       
            Route::resource('painel', DashboardController::class);
    });




