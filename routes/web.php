<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HpController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');


Route::middleware(['auth'])->group(function () {


    //Rotas da HomePage
    Route::get('/home_page', [HpController::class, 'index'])->middleware('auth')->name('home_page');
    Route::get('/', [HpController::class, 'index'])->name('home');
    Route::get('/produtos/search', [HpController::class, 'search'])->name('produtos.search');



    //Rotas de produto
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/manage', [ProdutoController::class, 'manage'])->name('admin.produtos.manage');
    Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('admin.produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('admin.produtos.store');
    Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.pvi');
    Route::get('/produtos/{produto}/comprar', [ProdutoController::class, 'comprar'])->name('produtos.comprar');
    Route::post('/produtos/{produto}/comprar', [ProdutoController::class, 'finalizarCompra'])->name('produtos.finalizarCompra');
    Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('admin.produtos.edit');
    Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('admin.produtos.update');
    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('admin.produtos.destroy');


    //Rotas de venda
    Route::get('/vendas/historico', [VendaController::class, 'historico'])->name('vendas.historico');
    Route::get('/vendas/relatorio-pdf', [VendaController::class, 'gerarPdf'])->name('vendas.pdf');
});




Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
