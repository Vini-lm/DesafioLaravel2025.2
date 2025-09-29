<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HpController;
use App\Http\Controllers\ProdutoController;
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

require __DIR__.'/auth.php';

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');



Route::get('/home_page', [HpController::class, 'index'])->middleware('auth')->name('home_page');
Route::get('/', [HpController::class, 'index'])->name('home');
Route::get('/produtos/search', [HpController::class, 'search'])->name('produtos.search');


Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/{id}', [ProdutoController::class, 'show'])->name('produtos.pvi');
Route::get('/produtos/{id}/comprar', [ProdutoController::class, 'comprar'])->name('produtos.comprar');


Route::post('/produtos/{id}/comprar', [ProdutoController::class, 'finalizarCompra'])->name('produtos.finalizarCompra');
