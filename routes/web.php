<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\ComprarBilheteController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\EstatisticaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarrinhoComprasController;
use App\Http\Controllers\HistoricoController;


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
Route::post('/criarRecibosBilhetes', [ComprarBilheteController::class, 'criarRecibosBilhetes']);

Route::get('/carrinhoCompras', [CarrinhoComprasController::class, 'carrinhoCompras'])->name('carrinhoCompras');
Route::post('/removerCarrinho', [CarrinhoComprasController::class, 'removerCarrinho'])->name('removerCarrinho');
Route::post('/carrinhoCompras', [CarrinhoComprasController::class, 'adicionarCarrinho']);

Route::get('/historico', [HistoricoController::class, 'historico'])->name('historico');
Route::get('/bilhetes/{id}', [BilheteController::class, 'mostrar'])->name('bilhetes.mostrar');
Route::get('/download-pdf/{id}', [BilheteController::class, 'gerarPDF'])->name('download-pdf');




//foi criado middleware AdminMiddleware para associar o utilizador do tipo A a administrador para a rota estar bloqueada a outros utilizadores
Route::middleware(['auth', 'admin'])->get('/estatistica', [EstatisticaController::class, 'index'])->name('estatistica');

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
