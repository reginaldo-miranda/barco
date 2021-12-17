<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Usuario;

class ClienteController extends Controller
{
    public function cadastrar(Request $request){
        $data = [];
        return view("cadastrar", $data);
     }

     public function cadastrarCliente(Request $request){

        $value = $request->all();
        $usuario = new Usuario();
        $usuario->fill($value);
        dd($usuario);


       return redirect()->route("cadastrar"); 
     }
}
