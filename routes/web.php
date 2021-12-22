<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;

/*
Route::get('/', function () {
    return view('home');
}); */

Route::match(['get','post'], '/',[ProdutoController::class,'index'])->name('home');


Route::match(['get','post'], '/categoria',[ProdutoController::class,'categoria'])->name('categoria');

Route::match(['get','post'], '/{idcategoria}/categoria',[ProdutoController::class,'categoria'])->name('categoria_por_id');

Route::match(['get','post'], '/cadastrar',[ClienteController::class,'cadastrar'])->name('cadastrar');

Route::post('/cliente/cadastrar',[ClienteController::class,'cadastrarCliente'])->name('cadastrar_cliente');

Route::match(['get','post'], '/{idproduto}/carrinho/adicionar',[ProdutoController::class,'adicionarCarrinho'])->name('adicionar_carrinho');

Route::match(['get','post'], '/carrinho',[ProdutoController::class,'verCarrinho'])->name('ver_carrinho');

Route::match(['get','post'], '/{indice}/excluircarrinho',[ProdutoController::class,'excluirCarrinho'])->name('carrinho_excluir');


Route::match(['get', 'post'], '/logar',[UsuarioController::class,'logar'])->name('logar');
Route::match(['get', 'post'], '/logar/sair',[UsuarioController::class,'sair'])->name('sair');



// fiz ate a aula 3 completa 

// aula 14 

// https://www.youtube.com/watch?v=mxQECfywOFA&t=39s&ab_channel=TheCoderBr // link da theCoder videos do curso


