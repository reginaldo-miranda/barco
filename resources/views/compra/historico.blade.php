@extends("layout") 
@section("conteudo")

    <div class="col-12">
        <h2>Minhas Compras</h2>
    </div>

    <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                   
                    <th>Data da Compra</th>
                    <th>Situacao</th>
                    <th></th>
                </tr>
            </thead>
            @foreach($lista as $ped)
                <tr>
                    <td>{{$ped ->datapedido->format("d/m/Y H:i") }}</td>
                    <td>{{$ped->statusDesc()}} </td>
                    <td></td>
                </tr>

            @endforeach
        </table>
    </div>

@endsection

