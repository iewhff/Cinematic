<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\ComprarBilheteController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


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

Route::get('/perfil', function () {
    return view('User.teste');
})->name('perfil');

Route::get('user/{user}/edit', [UserController::class, 'edit']);
Route::put('user/{user}', [UserController::class, 'update']);
Route::delete('user/{id}', [UserController::class, 'softDelete'])->name('user.softDelete');
Route::post('/user/upload-image', [UserController::class, 'uploadImage'])->name('user.uploadImage');
Route::post('/searchUser', [UserController::class, 'search'])->name('searchUser');
Route::resource('user', UserController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
