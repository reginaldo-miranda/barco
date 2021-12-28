<?php
namespace App\services;


use App\models\Usuario;
use App\models\Pedido;
use App\models\ItensPedido;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class VendaService { 
    
    public function finalizarVenda($prods = [], $user){

     // dd($prods)  ;
      Try{
       
      // DB::beginTransaction();

            $dthoje = new \DateTime();

            $pedido = new pedido();
            
            $pedido->datapedido = $dthoje->format("y-m-d H:i:s");
            $pedido->status = "PEN";
            
            $pedido->usuario_id = $user;
          // dd($pedido);
            $pedido->save();
            
            foreach($prods as $p){
                
                $itens = new ItensPedido();
               
                $itens->quantidade = 1;
                $itens->valor      = $p->valor;
                $itens->dt_item    = $dthoje->format("y-m-d H:i:s");
                $itens->produto_id = $p->id;
                $itens->pedido_id  = $pedido->id;
                $itens->save();
                
            } 

     //  DB::commit();
       return ['status' => 'ok', 'message' => 'venda finalizada com sucesso', 'idpedido'=>$pedido->id ]; 


      }catch(\Exception $e){
         // DB::rollBack();
          Log::error("ERRO:VENDA SERVICE", ['message' =>  $e->getMessage()]);
          return ['status' =>'err' , 'message' => 'venda nao pode ser finalizada'];
      }

    }

}