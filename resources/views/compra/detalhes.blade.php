<table class="table table-bordered">
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Valor</th>
    </tr>
    @foreach($listaItens as $itens)
        <tr>
            <td>{{ $itens->nome}} </td>
            <td>{{ $itens->quantidade}} </td>
            <td>{{ $itens->valoritens}} </td>

        </tr>
    @endforeach

</table>