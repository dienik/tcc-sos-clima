<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbrigoController;
use App\Http\Controllers\AbrigadoController;
use App\Http\Controllers\DoacaoController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemAbrigoController;
use App\Http\Controllers\PrioridadeController;
use App\Http\Controllers\AbrigoPrioridadesController;

Route::put('/abrigados/{id}', [AbrigadoController::class, 'update']);
Route::get('/abrigados/{id}', [AbrigadoController::class, 'edit']);

Route::delete('/abrigos/{abrigoId}/prioridades/{prioridadeId}', [AbrigoPrioridadesController::class, 'removerPrioridade']);

// Rota para editar o abrigo
Route::get('/abrigos/{pk_abrigo}', [AbrigoController::class, 'edit']);
// Rota para atualizar as informações do abrigo (método PUT)
Route::put('/abrigos/{pk_abrigo}', [AbrigoController::class, 'update']);

Route::get('/abrigos-prioridades', [AbrigoPrioridadesController::class, 'index'])->name('abrigos.prioridades');


Route::get('/prioridades', [PrioridadeController::class, 'index'])->name('prioridades.index');
Route::post('/prioridades/store', [PrioridadeController::class, 'store'])->name('prioridades.store');
Route::post('/prioridades/atribuir', [PrioridadeController::class, 'atribuir'])->name('prioridades.atribuir');

Route::get('/itens/cadastrar', [ItemAbrigoController::class, 'create'])->name('itens.create');
Route::post('/itens/cadastrar', [ItemAbrigoController::class, 'store'])->name('itens.store');

Route::resource('doacoes', DoacaoController::class);
Route::resource('itens', ItemController::class);
// Página inicial
Route::get('/', function () {
    return view('index');
});

// Rotas de Login e Registro
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rota protegida após login
Route::get('/home', function () {
    return view('home');
})->name('home');
Route::get('/abrigo/create', function () {
    return view('createAbrigo');
})->name('abrigo.create');
Route::get('/abrigo/listar', function () {
    return view('listarAbrigos');
})->name('abrigo.create');
Route::get('/abrigado/cadastrar', function () {
    return view('cadastrarPessoas');
})->name('abrigo.create');
Route::get('/abrigos', [AbrigoController::class, 'index']);

Route::post('/abrigo/store', [AbrigoController::class, 'store'])->name('abrigo.store');
Route::get('/abrigo/listar1', [AbrigoController::class, 'listar'])->name('abrigo.listar');

Route::post('/abrigado/store', [AbrigadoController::class, 'store'])->name('abrigado.store');
Route::post('/abrigado/upload', [AbrigadoController::class, 'importCsv'])->name('abrigado.upload');
Route::get('/abrigado/downloadCSV', [AbrigadoController::class, 'downloadCSV'])->name('abrigado.downloadCSV');
Route::get('/abrigado/listar', function () {
    return view('listarAbrigados');
})->name('abrigado.create');
Route::get('/abrigados', [AbrigadoController::class, 'index'])->name('abrigado.listar');
Route::get('/home/voluntario', function () {
    return view('voluntarioHome');
})->name('voluntario.view');
Route::get('/voluntario/doacao', [DoacaoController::class, 'create'])->name('doacoes.view');
Route::get('/cadastrar/itemAbrigo', [ItemAbrigoController::class, 'create'])->name('cadastrarItemAbrigo.view');

Route::get('/voluntario/doacao', [DoacaoController::class, 'create'])->name('doacoes.view');
