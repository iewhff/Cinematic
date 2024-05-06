<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\ComprarBilheteController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\EstatisticaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/filmes', [FilmeController::class, 'index'])->name('filmes');
Route::get('/detalhes', [FilmeController::class, 'detalhes'])->name('detalhes');

Route::get('/pesquisa', [PesquisaController::class, 'pesquisa'])->name('pesquisa');
Route::post('/pesquisa', [PesquisaController::class, 'pesquisa'])->name('pesquisa');

Route::get('/comprarBilhete', [ComprarBilheteController::class, 'comprarBilhete'])->name('comprarBilhete');
Route::post('/comprarBilhete', [ComprarBilheteController::class, 'criarReciboBilhete']);

Route::get('/estatistica', [EstatisticaController::class, 'index'])->name('estatistica');
