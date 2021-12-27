<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Categoria;
use App\models\Produto;
use App\services\VendaService;
use App\models\Pedido;
use App\Models\ItensPedido;
use App\models\Usuario;

use Illuminate\Support\Facades\Auth;
use PagSeguro\Configuration\Configure;
/*
use PagSeguro\Domains\AccountCredentials;
use PagSeguro\Domains\ApplicationCredentials;
use PagSeguro\Domains\Charset;
use PagSeguro\Domains\Environment;
use PagSeguro\Domains\Log;
use PagSeguro\Resources\Responsibility;
*/




class ProdutoController extends Controller
{

    private $_configs;

    public function __construct()
    {
       $this->_configs = new Configure();
       $this->_configs->setCharset("UTF-8");
       $this->_configs->setAccountCredentials(env('PAGSEGURO_EMAIL'), env('PAGSEGURO_TOKEN'));
       $this->_configs->setEnvironment(env("PAGSEGURO_AMBIENTE"));
       $this->_configs->setLog(true, storage_path('logs/pagueseguro_' . date('Ymd'). '.log '));
    }

    

    public function getCredential(){

       return $this->_configs->getAccountCredentials(); // espeara dois argumentos
    }

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
         //  dd($request);
           $data = [];
           $carrinho = session('cart', []);
           $data['cart'] = $carrinho;

           $sessionCode = \PagSeguro\Services\Session::create(
              $this->getCredential()
            );
                  
           $IDSession = $sessionCode->getRsult();
           $data['sessionID'] = $IDSession;
       
           return view("compra/pagar" , $data) ;
        }
     }
   
