<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//use App\Http\Controllers\Auth;

class UsuarioController extends Controller
{
    public function logar(Request $request){
     
     $data = [];
 
      if($request->isMethod("POST")){
          $login = $request->input("login");
          $senha = $request->input("senha");

          $credential = ['login' => $login , 'password' => $senha];
         
          if(Auth::attempt($credential)){
                return redirect()->route('home');

          }else{
            $request->session()->flash("err", "Usuario/senha invalido" ) ;
            return redirect()->route('logar');
          }
      }

     return view("logar", $data);
     
    }
}