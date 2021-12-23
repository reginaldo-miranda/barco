<?php

namespace App\Models;


class Pedido extends RModel
{
   protected $table = "pedidos";

   protected $fillable = ['datapedido', 'status', 'usuario_id',];
}
