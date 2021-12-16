<?php

namespace App\Http\Controllers;
use App\models\Categoria;
use App\models\Produto;


use Illuminate\Http\Request;

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
           
         }
         return redirect()->route('home');
     }
}
