<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Usuario;
use App\models\Endereco;

class ClienteController extends Controller
{
    public function cadastrar(Request $request){
        $data = [];
        return view("cadastrar", $data);
     }

     public function cadastrarCliente(Request $request){

        $values = $request->all();
        $usuario = new Usuario();
        $usuario->fill($values);
        $usuario->login = $request->input('cpf', "");
       
        $endereco = new Endereco($values);
        $endereco->logradouro = $request->input('endereco' , "");
     
       try {
         $usuario->save();
         $endereco->usuario_id = $usuario->id; // relacionamento das tabelas
         dd('salvo usuario') ;
         $endereco->save(); 

       } catch (\Exception $e) {
         //throw $th;
       }




       return redirect()->route("cadastrar"); 
     }
}
