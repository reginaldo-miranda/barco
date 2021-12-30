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


class ProdutoController extends Controller
{

    public $_configs;

    public function __construct()
    {
           
      $this->_configs = new Configure();
      $this->_configs->setCharset("UTF-8");

      $this->_configs->setAccountCredentials(env('PAGSEGURO_EMAIL'), env('PAGSEGURO_TOKEN'));
 
      $this->_configs->setEnvironment(env("PAGSEGURO_AMBIENTE"));
      // $this->_configs->setLog(true, storage_path('logs/pagueseguro_' . date('Ymd'). '.log '));
      $this->_configs->setLog(true, storage_path('logs/laravel'.'.log '));
     
        
    }

    

    public function getCredential(){
    
      return $this->_configs->getAccountCredentials(); 
   
     
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
         dd('finalizar');
         $prods = session('cart', []);
         
         
         $usuario = new Usuario();

         if (Auth::check()) {
             
             $user = Auth::user()->id;
         
            $vendaService = new VendaService();
         $result = $vendaService->finalizarVenda($prods, $user) ;
         
        }else{
            return redirect()->route('ver_carrinho');
        }
       
         

         if($result["status"]== "ok"){
           // session()->forget('cart');

          
             $credCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
             $credCard->setReference("PED_" . $result["idpedido"]);
             $credCard->setCurrency("BRL");
             foreach ($prods as $p){
                $credCard->addItems()->withParameters(
                   $p->id,
                   $p->nome,
                   1,
                   number_format($p->valor,2, ".", '')
                );
             }
             $user = Auth::user();
             $credCard->setSender()->setName($user->nome . "" . $user->nome);
            // $credCard->setSender()->setEmail($user->email);
             $credCard->setSender()->setEmail($user->login . "@sandbox.pagseguro.com.br ");
             $credCard->setSender()->setHash('t$req->input("hashseller")');
             $credCard->setSender()->setPhone()->withParameters(21, 45455555);
             $credCard->setSender()->setDocument()->withParameters("CPF", $user->login);

             $credCard->setShipping()->setAddress()->withParameters(
               'Av A', '1234', 'jd botanico', '222222222', 'Rio de Janeiro' , 'RJ', 'BRA', 'Ap .100'

             );
             $credCard->setBilling()->setAddress()->withParameters(
               'Av A', '1234', 'jd botanico', '222222222', 'Rio de Janeiro' , 'RJ', 'BRA', 'Ap .100'

             );
             $credCard->setToken('$req->input("cardtoken")');

             $parcela = '$req->input("nparcela")';
             $totalapagar = '$req->input("totalpagar")';
             $totalParcela = '$req->input("totalParcela")';

             $credCard->setInstallment()->withParameters($parcela, number_format($totalParcela, 2, ".", ""));

               // dados titular do cartao
               $credCard->setHolder()->setName($user->nome . "" . $user->nome);
               $credCard->setHolder()->setDocument()->withParameters("CPF", $user->login);
               $credCard->setHolder()->setBirthDate("11/01/1959");
               $credCard->setHolder()->setPhone()->withParameters(21, 45455555);
               $credCard->setMode("Default");
               $result = $credCard->register($this->getCredential());
               echo "Compra realizada com sucesso !";

         }else{
            echo "compra nao realizada";
         }

        // $request->session()->flash($result["status"], $result['message']);
        // return redirect()->route("ver_carrinho");
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
          //dd($request);
           $data = [];

           $carrinho = session('cart', []);
           $data['cart'] = $carrinho;
       
           $sessionCode = \PagSeguro\Services\Session::create(
            
            $this->getCredential()
            );
         
                
           $IDSession = $sessionCode->getResult();
           $data['sessionID'] = $IDSession;
           //dd($data);
       
           return view("compra/pagar" , $data) ;
        }
     }
   
  