<?php

namespace App\Models;



class Endereco extends RModel
{
    protected $table = "enderecos";
  //  protected $keyType = 'int';

    protected $fillable = ['numero' , 'complemento' , 'cidade',  'cep' , 'estado' , 'logradouro', 'usuario_id'];

    public function usuario(){

      return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function setCepinAttribute($cep){

      $value = preg_replace("/[^0-9]/","", $cep);
      $this->attributes["cep"] = $value;
    }

}
