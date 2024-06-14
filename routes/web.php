<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BilheteController;
use App\Http\Controllers\ComprarBilheteController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\EstatisticaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarrinhoComprasController;
use App\Http\Controllers\EditarFilmesController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\SessaoController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ControloController;



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

Route::get('/limpar-carrinho', function () {
    Session::forget('carrinho');
    return response()->json(['message' => 'Carrinho limpo com sucesso']);
})->name('limpar-carrinho');


Route::get('/', [FilmeController::class, 'welcome'])->name('welcome');
Route::get('/filmes', [FilmeController::class, 'index'])->name('filmes');
Route::get('/detalhes', [FilmeController::class, 'detalhes'])->name('detalhes');
Route::get('/sessoes', [FilmeController::class, 'show'])->name('sessoes');

Route::middleware(['auth', 'admin'])->get('/editarFilmes', [EditarFilmesController::class, 'index'])->name('editarFilmes');
Route::middleware(['auth', 'admin'])->get('/editar', [EditarFilmesController::class, 'editar'])->name('editar');
Route::middleware(['auth', 'admin'])->post('/editar', [EditarFilmesController::class, 'editar'])->name('editar');
Route::middleware(['auth', 'admin'])->get('/gravarEditar', [EditarFilmesController::class, 'gravarEditar'])->name('gravarEditar');
Route::middleware(['auth', 'admin'])->post('/adicionar', [EditarFilmesController::class, 'adicionar'])->name('adicionar');
Route::middleware(['auth', 'admin'])->get('/adicionarFilme', [EditarFilmesController::class, 'adicionarFilme'])->name('adicionarFilme');
Route::middleware(['auth', 'admin'])->post('/eliminar', [EditarFilmesController::class, 'eliminar'])->name('eliminar');
Route::middleware(['auth', 'admin'])->get('/eliminarFilme', [EditarFilmesController::class, 'eliminarFilme'])->name('eliminarFilme');

Route::get('/pesquisa', [PesquisaController::class, 'pesquisa'])->name('pesquisa');
Route::post('/pesquisa', [PesquisaController::class, 'pesquisa'])->name('pesquisa');


Route::get('/escolherSessao', [SessaoController::class, 'escolherSessao'])->name('escolherSessao');
Route::get('/escolherLugar', [SessaoController::class, 'escolherLugar'])->name('escolherLugar');
Route::get('/comprarBilhete', [ComprarBilheteController::class, 'comprarBilhete'])->name('comprarBilhete');
Route::post('/comprarBilhete', [ComprarBilheteController::class, 'criarReciboBilhete']);
Route::post('/criarRecibosBilhetes', [ComprarBilheteController::class, 'criarRecibosBilhetes']);

Route::get('/carrinhoCompras', [CarrinhoComprasController::class, 'carrinhoCompras'])->name('carrinhoCompras');
Route::post('/removerCarrinho', [CarrinhoComprasController::class, 'removerCarrinho'])->name('removerCarrinho');
Route::post('/removerTudoCarrinho', [CarrinhoComprasController::class, 'removerTudoCarrinho'])->name('removerTudoCarrinho');
Route::post('/carrinhoCompras', [CarrinhoComprasController::class, 'adicionarCarrinho']);
Route::get('/carrinhoCompras/{id}', [CarrinhoComprasController::class, 'carrinhoCompras']);

Route::get('/historico', [HistoricoController::class, 'historico'])->name('historico');

Route::get('/downloadBilhetePdf/{id}', [BilheteController::class, 'downloadBilhetePdf'])->name('downloadBilhetePdf');
Route::get('/downloadReciboPdf/{id}', [BilheteController::class, 'downloadReciboPdf'])->name('downloadReciboPdf');

Route::get('/picarSessao', [ControloController::class, 'picarSessao'])->name('picarSessao');

Route::post('/formN', [ControloController::class, 'formN'])->name('formN');
Route::get('/backForm', [ControloController::class, 'backForm'])->name('backForm');
Route::get('/form', function () {
    return view('controloAcesso.form');  // Esta rota exibe o formulário
});
Route::post('/processar-form', [ControloController::class, 'processarForm'])->name('processar.form');  // Esta rota processa o formulário
Route::post('/validar/{id}/{idSessao}', [ControloController::class, 'showBilhete'])->name('bilhete.show');


//foi criado middleware AdminMiddleware para associar o utilizador do tipo A a administrador para a rota estar bloqueada a outros utilizadores
Route::middleware(['auth', 'admin'])->get('/estatistica', [EstatisticaController::class, 'index'])->name('estatistica');

Route::get('/perfil', function () {
    $tipoUser = \App\Models\User::$tipoUser;
    $tipoPagamentos = \App\Models\Cliente::$tipoPagamentos;
    return view('User.perfil', compact('tipoUser', 'tipoPagamentos'));
})->name('perfil');

Route::put('/perfil', [UserController::class, 'update'])->name('perfil.update');


Route::middleware(['auth', 'admin'])->get('/users', [UserController::class, 'index'])->name('users');

Route::middleware(['auth', 'admin'])->get('/users.create', [UserController::class, 'create'])->name('users.create');
Route::middleware(['auth', 'admin'])->post('/users.store', [UserController::class, 'store'])->name('users.store');


Route::middleware(['auth', 'admin'])->get('user/{user}', [UserController::class, 'show'])->name('user.show');
Route::middleware(['auth', 'admin'])->get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');

/*Route::middleware(['auth', 'admin'])->get('user/{user}/edit', function () {
    $tipoUser = \App\Models\User::$tipoUser;
    return view('User.edit', compact('tipoUser'));
})->name('user.edit');*/

Route::middleware(['auth', 'admin'])->put('user/{user}', [UserController::class, 'editUpdate'])->name('user.update');

Route::middleware(['auth', 'admin'])->put('/user/{user}/block', [UserController::class, 'block'])->name('user.block');
Route::middleware(['auth', 'admin'])->put('/user/{user}/unblock', [UserController::class, 'unblock'])->name('user.unblock');
Route::middleware(['auth', 'admin'])->delete('user/{id}', [UserController::class, 'softDelete'])->name('user.softDelete');
Route::middleware(['auth', 'admin'])->post('/user/upload-image', [UserController::class, 'uploadImage'])->name('user.uploadImage');
Route::middleware(['auth', 'admin'])->post('/searchUser', [UserController::class, 'search'])->name('searchUser');
Route::resource('user', UserController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
