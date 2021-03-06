@extends("layout")

@section("scriptjs")
  <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
  {{-- <script src ="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  

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
                     var hash = response.senderHash;
                     $(".hashseller").val(hash)
              })

         })
    });
      
   /*   

        $(".nparcela").on('blur' , function(){
            var bandeira = 'visa';
           $(".bandeira").val();

            var totalParcela = $(this).val();

            PagSeguroDirectPayment.getInstallments({
               amount : $(".totalfinal").val() ,
               maxIntallmentNointerest : 2,
               brand : bandeira,
               success : function(response){
                   console.log(response);
               }
            })
       })
*/
   /*             
                   let status = response.error
                   if(status){
                       alert('Nao foi encontrado opcoes de parcelamento')
                       return;
                   }
                   let indice = totalParcela - 1;
                   let totalapagar = response.installments(bandeira)[indice].totalAmount
                   let valorTotalParcela = response.installments(bandeira)[indice].installmentAmount
                   $('.totalparcela').val(valorTotalParcela);
                   $('.totalapagar').val(totalapagar);
               } 
            })
       })
       
        $(".pagar").on("click" , function(){
            var numerocartao = $(".ncredito").val()
            var iniciocartao = numerocartao.substr(0,6)
            var ncvv       = $(".ncvv").val()
            var anoexp     = $(".anoexp").val()
            var mesexp     = $(".mesexp").val()
            var hashseller = $(".hashseller").val()
            var bandeira   = $(".bandeira").val()

            PagSeguroDirectPayment.createCardToken({
                cardNumber : numerocartao,
                brand : bandeira,
                cvv : ncvv,
                expirationMonth : mesexp,
                expirationYear : anoexp,
                success : function(response){
                  $.post(' {{route("carrinho_finalizar")}}' ,{
                        hashseller : hashseller,
                        cardtoken  : response.card.token,
                        nparcela : $(".nparcela").val(),
                        totalapagar : $(".totalapagar").val(),
                        totalParcela : $(".totalParcela").val()
                  }, function(){
                      alert(result)
                  
                  }); 
                };
                error : function(err){
                   alert("Nao pode buscar o token do cartao verifique todos os campos") 
                   console.log(err)
                }

            })
        })
    })*/
  });
  
  </script>
@endsection

@section("conteudo")
  <form>
       @php $total = 0 ; @endphp 
        @if(isset($cart) && count($cart) > 0)

        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>valor</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($cart as $indice => $p )
                    <tr>
                        <td>{{$p->nome}}</td>  
                        <td>{{$p->valor}}</td>  
                    </tr>
                   @php $total += $p->valor; @endphp      
               @endforeach 
            </tbody>
                
        </table>
    @endif


        <input type="text" name="hashseller" class="hashseller">

        <input type="text" name="bandeira" class="bandeira">
        <div class ="row">

            <div class="col-4">
                Cartao de Credito:
                <input type="text" name="ncredito" class="ncredito form-control" />
            </div>
             <div class="col-4">
                Bandeira:
                <input type="text" name="bandeira" class="bandeira form-control" />
            </div>

            <div class="col-4">
                CVV:
                <input type="text" name="ncvv" class="ncvv form-control"/>
            </div>

            <div class="col-4">
                Mes de expiracao: 
               <input type="text"  namee="mesexp" class="mesexp form-control"/>
            </div>

            <div class="col-4">
                Ano de expiracao: 
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

{{-- 
/* comprador teste 4111111111111111 visa validade 12/2030  cvv 123  
Email: c27606960806091243446@sandbox.pagseguro.com.br
Senha: 865346725N6M0j6T

env

PAGSEGURO_EMAIL=reginaldobrain@gmail.com
PAGSEGURO_TOKEN=2F0BA225966C4101A223300BC255516C
PAGSEGURO_AMBIENTE=sandbox


$( "#target" ).blur(function() {
  alert( "Handler for .blur() called." );
});


https://labs.bawi.io/checkout-transparente-com-pagseguro-7dfb0a164492 link de codigo
 */ --}}