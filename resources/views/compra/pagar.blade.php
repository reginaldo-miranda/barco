@extends("layout")

@section("scriptjs")
  <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
  <script src ="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    function carregar(){
        PagSeguroDirectPayment.setSessionId('{{ $sessionID }} ')

    }
    $(function(){
        carregar();
        $(".ncredito").on('blur', function(){
            PagSeguroDirectPayment.onSenderHashReady(function(response){
                if(response.status == 'error'){
                    console.log(response.message);
                    return false
                }
                var hash = response.onSenderHash
                $(".hashseller").val(hash)
              
        })
        $(".nparcela").on('blur' , function(){
            var bandeira = 'visa';
            var totalParcela = $(this).val();

            PagSeguroDirectPayment.getInstallments({
               amount : $(".totalfinal").val() ,
               maxIntallmentNointerest : 2,
               brand : bandeira,
               success : function(response){
                   console.log(response);
                   let status = response.error
                   if(status){
                       alert('Nao foi encontrado opcoes de parcelamento')
                       return;
                   }
                   let indice = totalParcela - 1;
                   let totalapagar = response.installments(bandeira)[indice].totalAmount
                   let valorTotalParcela = response.installments(bandeira)[indice].installmentAmount
                   $(".totalparcela").val(valorTotalParcela)
                   $(".totalapagar").val(totalapagar)
               }
            })
        })
    })
  
  </script>
@endsection

@section("conteudo")
  <form>
    @php $total += $p->valor; @endphp  
        @if(isset($cart) && count($cart) > 0)

        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>valor</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 ; @endphp       
                @foreach ($cart as $indice => $p )
                    <tr>
                        <td>{{$p->nome}}</td>  
                        <td>{{$p->valor}}</td>  
                    
                    </tr>
              
                @endforeach 

            </tbody>
                
        </table>
    @endif


        <input type="text" name="hashseller" class="hashseller">
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
               <input type="text"  namee="totalfinal" value="{{$total}} "class="totalfinal form-control" readonly />
            </div>

            <div class="col-4">
                Valor da parcela: 
               <input type="text"  namee="totalparcela" class="totalParcela form-control"/>
            </div>

            <div class="col-4">
                Total a Pagar: 
               <input type="text"  namee="totalapagar " class="totalapagar form-control"/>
            </div>
        </div>
         @csrf
         <input type="button" value="Pagar" class="btn btn-lg btn-success pagar" />
    </form>


@endsection