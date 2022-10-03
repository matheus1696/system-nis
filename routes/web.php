<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

#Route::get('/', function () {
#    return view('welcome');
#});

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//Rota de Autenticação
    require __DIR__.'/auth.php'; 

//Rota de Configuração
    require __DIR__.'/rotas/config.php'; 

//Rota de CNEP
    require __DIR__.'/rotas/cnep/capacitacao.php';

//Rota de Painel de Dashboard
    require __DIR__.'/rotas/dashboard.php'; 

//Rota de Painel de Usuário Comum
    require __DIR__.'/rotas/user.php'; 
