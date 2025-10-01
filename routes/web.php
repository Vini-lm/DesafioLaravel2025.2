<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HpController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PagSeguroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

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
    Route::get('/home_page', [HpController::class, 'index'])->middleware('auth')->name('home_page');
    Route::get('/', [HpController::class, 'index'])->name('home');
    //Route::get('/produtos/search', [HpController::class, 'search'])->name('produtos.search');

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


    Route::get('/vendas/historico', [VendaController::class, 'historico'])->name('vendas.historico');
    Route::get('/vendas/relatorio-pdf', [VendaController::class, 'gerarPdf'])->name('vendas.pdf');

    Route::get('/compras/historico', [CompraController::class, 'historico'])->name('compras.historico');
    Route::get('/compras/relatorio-pdf', [CompraController::class, 'gerarPdf'])->name('compras.pdf');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/users/{user}/email', [UserController::class, 'createEmail'])->name('users.email.create');
    Route::post('/users/{user}/email', [UserController::class, 'sendEmail'])->name('users.email.send');
  

    
});
    

Route::get('/user', function(Request $request){
    return $request->user();
})->middleware('auth:sanctum')->name('user');

//rota da api de cep
Route::get('/api/cep/{cep}', [UserController::class, 'cepApi'])->name('cep.api');

//rota da api de pagamento
Route::post('/checkout',[PagSeguroController::class, 'createCheckout'])->name('pagseguro.checkout');

Route::get('/erro-pagamento', function () {
    return view('pagamento-erro');
})->name('pagamento.erro');

//rota de email
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


//rota de logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

