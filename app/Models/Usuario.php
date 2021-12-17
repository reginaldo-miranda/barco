<?php

namespace App\Models;



class Usuario extends RModel
{
    protected $table = "usuarios";

    protected $fillable = ['login', 'email', 'password', 'nome'];
}
