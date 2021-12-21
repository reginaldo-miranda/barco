<?php

namespace App\Models;



class Endereco extends RModel
{
    protected $table = "enderecos";
  //  protected $keyType = 'int';

    protected $fillable = ['logradouro' , 'numero' , 'cidade',  'estado' , 'cep' , 'complemento'];
}
