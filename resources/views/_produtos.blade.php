  @if(isset($lista))
    <div class="row">
            @foreach ($lista as $prod )
                
                <div class="col-4 mb-3">
                    <div class="card">
                        <img src="{{ asset($prod->foto) }}" height="190" class="card-img-top"/>
                        <div class="card-body">
                            <h6 class="card-title">{{ $prod->nome}} - {{$prod->valor }}</h6>
                            <a href="{{ route('adicionar_carrinho', ['idproduto' => $prod->id] )}}" class="btn btn-sm-secondary">Adicionar Iten </a>
                        </div>
                    </div>
            </div>  
            @endforeach
     </div>       
    @endif 