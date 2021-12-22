<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;

class Usuario extends RModel implements Authenticatable
{
   // protected $primaryKey = "id";
  //  protected $keyType = 'int';
    protected $table = "usuarios";

    protected $fillable = ['login', 'email', 'password', 'nome'];

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

    public function setLoginAttribute($login){

      $value = preg_replace("/[^0-9]/","", $login);
      $this->attributes["login"] = $value;
    }


    

}
