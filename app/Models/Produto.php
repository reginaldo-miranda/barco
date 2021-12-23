<?php

namespace App\Models;
use Illuminate\Contracts\Auth\Authenticatable;

class Produto extends RModel  implements Authenticatable

{
     protected $table = "produtos";
     protected $fillable = ['nome', 'foto', 'descricao', 'categoria_id', 'valor'];

     
    public function getAuthIdentifierName(){
     return $this->getKey();
   }
   public function getAuthIdentifier(){
      return $this->login;
   }
   public function getAuthPassword(){
       return $this->password;
   }
   public function getRememberToken(){
     return $this->token;
   }
   public function setRememberToken($value){
     $this->token = $value;
   }
   public function getRememberTokenName(){
     return 'token';
   }

}
