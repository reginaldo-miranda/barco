<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $cat = new \App\Models\Categoria(['categoria' => 'Geral']);
        $cat->save();

        $prod = new \App\Models\Produto(['nome' => 'Produto 1', 'valor' => 10, 'foto' => 'imagens/produtos/exemplo01.jpg', 'descricao' => '', 'categoria_id' => $cat->id]);
        $prod->save();

        $prod = new \App\Models\Produto(['nome' => 'Produto 2', 'valor' => 10, 'foto' => 'imagens/produtos/exemplo02.jpg', 'descricao' => '', 'categoria_id' => $cat->id]);
        $prod->save();

        $prod = new \App\Models\Produto(['nome' => 'Produto 3', 'valor' => 10, 'foto' => 'imagens/produtos/exemplo03.jpg', 'descricao' => '', 'categoria_id' => $cat->id]);
        $prod->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
