<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request){
       $data = [];
       return view("home", $data);
    }

    public function categoria(Request $request){
        $data = [];
        return view("categoria", $data);
     }
}
