<?php

namespace App\Models;



class Endereco extends RModel
{
    protected $table = "endereco";
    protected $keyType = 'int';

    protected $fillable = ['logradouro' , 'numero' , 'cidade',  'estado' , 'cep' , 'complemento'];
}
