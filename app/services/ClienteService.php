<?php


use Illuminate\Support\Facades\Hash;

namespace App\Http\Controllers;
namespace App\services;
use App\User;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\models\Usuario;
use App\models\Endereco;

class ClienteService{

    public function salvarUsuario(Usuario $user, Endereco $endereco){
      //dd($user);
      
        try {
            $dbUsuario = Usuario::where("login", $user->login)->first();
            if($dbUsuario){
              return ['status' => 'err' , 'message' => "Login ja cadastrado no sistema!"];
            }
              
          //  DB::beginTransaction();
              
            $user->save();
            
             $endereco->usuario_id = $user->id; // relacionamento das tabelas
            //  dd($endereco);
             $endereco->save(); 
          // DB::commit();
             return ['status' => 'ok' , 'message' => "Usuario cadastrado com sucesso !"];
    
           } catch (\Exception $e) {
            Log::error("ERRO", ['file' =>'ClienteService.salvarUsuario',
                                       'message' => $e->getMessage()]);
          //  DB::rollback();
            return ['status' => 'err' , 'message' => "Nao pode cadastrar o usuario !"];
           }


    }



}