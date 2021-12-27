@extends("layout")

@section("scriptjs")
  
@endsection

@section("conteudo")
    <form>
        <div class ="row">

            <div class="col-4">
                Cartão de Credito:
                <input type="text" name="ncredito" class="ncredito form-control" />
            </div>

            <div class="col-4">
                CVV:
                <input type="text" name="ncvv" class="ncvv form-control"/>
            </div>

            <div class="col-4">
                Mes de expiração: 
               <input type="text"  namee="mesexp" class="mesexp form-control"/>
            </div>

            <div class="col-4">
                Ano de expiração: 
               <input type="text"  namee="anoexp" class="anoexp form-control"/>
            </div>

            <div class="col-4">
                Nome no cartao: 
               <input type="text"  namee="nomecartao" class="nomecartao form-control"/>
            </div>

            <div class="col-4">
                Parcelas: 
               <input type="text"  namee="nparcela" class="nparcela form-control"/>
            </div>

            <div class="col-4">
                Valor Total: 
               <input type="text"  namee="totalfinal" class="totalfinal form-control"/>
            </div>

            <div class="col-4">
                Valor da parcela: 
               <input type="text"  namee="totalparcela" class="totalparcela form-control"/>
            </div>
        </div>
         @csrf
         <input type="button" value="Pagar" class="btn btn-lg btn-success pagar" />
    </form>


@endsection