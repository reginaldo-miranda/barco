<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\models\Categoria;
use App\Models\ItensPedido;
use App\models\Produto;
use App\models\Usuario;
use App\models\Pedido;
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
         
            $vendaService = new VendaService();
         $result =   $vendaService->finalizarVenda($prods, $user) ;
         
        }else{
            return redirect()->route('ver_carrinho');
        }
       
         

         if($result["status"]== "ok"){
            session()->forget('cart');
         }

         $request->session()->flash($result["status"], $result['message']);


      return redirect()->route("ver_carrinho");
     }

     public function historico(){

         $data=[];

         
         $usuario = Auth::user()->id;
         
         $listaPedido = pedido::where("usuario_id" , $usuario)->orderBy("datapedido", "desc")->get();

         $data["lista"] = $listaPedido;

      return view('compra/historico' , $data);
     }

     public function detalhes(Request $request){
         $idpedido = $request->input("idpedido");
         
         $listaItens = itensPedido::join("produtos" , "produtos.id", "=", "itens_pedidos.produto_id")
                                    ->where("pedido_id" , $idpedido)
                                    ->get(['itens_pedidos.*' , 'itens_pedidos.valor as valoritens' , 'produtos.*'] );
         $data = [];

         $data["listaItens"] = $listaItens;
         return view("compra/detalhes" , $data);

     }

     public function pagar(Request $request){
           $data = []  ;


           return view("compra/pagar" , $data) ;
       
     }
}
