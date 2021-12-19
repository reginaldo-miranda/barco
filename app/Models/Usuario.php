<?php

namespace App\Models;



class Usuario extends RModel
{
    protected $primaryKey = "id";
    protected $keyType = 'int';
    protected $table = "usuarios";

    protected $fillable = ['login', 'email', 'password', 'nome'];
}
