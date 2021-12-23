<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Categoria;
use App\models\Produto;
use App\models\Usuario;
use App\services\VendaService;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public function index(Request $request){
       $data = [];
       $listaprodutos = produto::all();
       $data['lista'] = $listaprodutos;

       return view("home", $data);
    }

    public function categoria($idcategoria=0, Request $request){

     
        $data = [];

         $listaCategorias = Categoria::all();
        
         $queryprodutos = produto::limit(3);

         if($idcategoria != 0){
            $queryprodutos->where("categoria_id" , $idcategoria);
         }
         $listaprodutos = $queryprodutos->get();
        
         $data["lista"] = $listaprodutos;
         $data["listaCategoria"] = $listaCategorias ;
         $data["idcategoria"] = $idcategoria;
         
        return view("categoria", $data);
      
     }

     public function adicionarCarrinho($idproduto = 0 , Request $request){

         $prod = Produto::find($idproduto);

         if($prod){
              $carrinho = session('cart',[]);
               array_push($carrinho, $prod);
              session(['cart' => $carrinho]);
           
         }
         return redirect()->route('home');
     }

     public function verCarrinho(Request $request){
       $carrinho = session('cart', []);
       
       $data = [ 'cart' => $carrinho ];

       return view('carrinho',$data);

     }

     public function excluirCarrinho( $indice, Request $request){

       $carrinho = session('cart', []);
       if(isset($carrinho[$indice])){
          unset($carrinho[$indice]);

       }
       session(['cart' => $carrinho]);
       return redirect()->route("ver_carrinho");

     }

     public function finalizar(Request $request){

         $prods = session('cart', []);
         
       
         $usuario = new Usuario();

         if (Auth::check()) {
           
             $user = Auth::user()->id;
            // dd($usuario);
            $vendaService = new VendaService();
         $result =   $vendaService->finalizarVenda($prods, $user) ;
            //dd('autenticado');// The user is logged in...
        }else{
            dd('nao autenticado');
        }
       
         

         if($result["status"]== "ok"){
            $request()->session()->forget("cart");
         }

         $request->session()->flash($result["status"], $result['message']);


      return redirect()->route("ver_carrinho");
     }
}
