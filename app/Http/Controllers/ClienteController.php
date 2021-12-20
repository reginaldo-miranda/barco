<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\models\Usuario;
use App\models\Endereco;
use DB;

class ClienteController extends Controller
{
    public function cadastrar(){
        $data = [];
        return view("cadastrar", $data);
     }

     public function cadastrarCliente(Request $request){

        $values = $request->all();
               
        $usuario = new Usuario;
        $usuario->fill($values);
        $usuario->login = $request->input('cpf', "");
        
        $senha = $request->input("password", "");
        $usuario->password = Hash::make($senha);
        
        $endereco = new Endereco($values);
        $endereco->logradouro = $request->input('endereco' , ""); 
       // dd($endereco);
          
       try {
         DB::beginTransaction();
         $usuario->save();
         throw new \Exception("ERRO DEPOIS DE SALVAR O USUARIO");
         
         $endereco->usuario_id = $usuario->id; // relacionamento das tabelas
        
         $endereco->save(); 
         DB::commit();
         

       } catch (\Exception $e) {
         DB::rollback();
       }

       return redirect()->route("cadastrar"); 
     }
}
