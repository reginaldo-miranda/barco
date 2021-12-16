<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;

/*
Route::get('/', function () {
    return view('home');
}); */

Route::match(['get','post'], '/',[ProdutoController::class,'index'])->name('home');


Route::match(['get','post'], '/categoria',[ProdutoController::class,'categoria'])->name('categoria');

Route::match(['get','post'], '/{idcategoria}/categoria',[ProdutoController::class,'categoria'])->name('categoria_por_id');

Route::match(['get','post'], '/cadastrar',[ClienteController::class,'cadastrar'])->name('cadastrar');

Route::match(['get','post'], '/{idproduto}/carrinho/adicionar',[ProdutoController::class,'adicionarCarrinho'])->name('adicionar_carrinho');


// fiz ate a aula 3 completa 

// aula 9 proxima aula 5,14 https://www.youtube.com/watch?v=7JjJJgkiX8E&ab_channel=TheCoderBr


