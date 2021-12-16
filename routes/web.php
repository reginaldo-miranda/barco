<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;

/*
Route::get('/', function () {
    return view('home');
}); */

Route::match(['get','post'], '/',[ProdutoController::class,'index'])->name('home');


Route::match(['get','post'], '/categorria',[ProdutoController::class,'categoria'])->name('categoria');

Route::match(['get','post'], '/cadastrar',[ClienteController::class,'cadastrar'])->name('cadastrar');


// fiz ate a aula 3 completa 

// aula 4 proxima aula https://www.youtube.com/watch?v=otmfl_9dh-s&ab_channel=TheCoderBr 


