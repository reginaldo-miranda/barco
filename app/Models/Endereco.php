<?php

namespace App\Models;



class Endereco extends RModel
{
    protected $table = "endereco";

    protected $fillable = ['logradouro' ,'complemento' , 'numero' , 'cep' , 'estado'];
}
