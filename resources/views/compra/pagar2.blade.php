@extends("layout")
@section("scriptjs")
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
  {{--   <script src ="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        function carregar(){
        
            PagSeguroDirectPayment.setSessionId('{{ $sessionID }} ')

        }

        PagSeguroDirectPayment.getPaymentMethods({
            amount: 500.00,
            success: function(response) {
                // Retorna os meios de pagamento disponíveis.
            },
            error: function(response) {
                // Callback para chamadas que falharam.
            },
            complete: function(response) {
                // Callback para todas chamadas.
            }
        });
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
          
               });

              })
           
        })
    
    </script>

@endsection

@section("conteudo")
    <form>
       {{$sessionID}}
        <p>aqui dentro do form</p>

         <input type="text" name="hashseller" class="hashseller">

        <input type="text" name="bandeira" class="bandeira">
        <div class ="row">

            <div class="col-4">
                <lable>cartao</lable>
                <input type="text" name="ncredito" class="ncredito form-control" />
            </div>

            <div class="col-4">
                <lable>C v v</lable>
                <input type="text" name="ncvv" class="ncvv form-control"/>
            </div>    
    </form>


@endsection
