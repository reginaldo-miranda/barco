<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\models\Usuario;
use App\models\Endereco;
use App\services\ClienteService;
use Illuminate\Support\Facades\DB;


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
       // dd($usuario);
        $endereco = new Endereco($values);
        
        $endereco->logradouro = $request->input('endereco' , ""); 
        //dd($endereco);
        $ClienteService = new ClienteService();
        $result = $ClienteService->salvarUsuario($usuario, $endereco);
      
        $message = $result["message"];
        $status = $result["status"];

        $request->session()->flash($status, $message);

       return redirect()->route("cadastrar"); 
     }
}
