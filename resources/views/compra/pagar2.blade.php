@extends("layout")
@section("scriptjs")
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script>
        function carregar(){
        
            PagSeguroDirectPayment.setSessionId('{{ $sessionID }} ')

        }

//Passo 2
// Como todas as chamadas à API serão realizadas diretamente no navegador do usuário, sua aplicação web precisa incluir o código JavaScript da biblioteca.
        
        /*
// Passo 3
// Com o ID de sessão obtido, você deve definí-lo no lado cliente.
        PagSeguroDirectPayment.setSessionId('ID_DA_SESSÃO_OBTIDO_NO_PASSO_1');
*/
// Passo 4
// Agora nós consultamos os métodos de pagamento disponíveis.

        PagSeguroDirectPayment.getPaymentMethods({
            amount: $(".totalfinal").val() ,
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

// Passo 5
// O usuário que fará o pagamento precisa ser identificado através de um código hash.
        PagSeguroDirectPayment.onSenderHashReady(function(response){
            if(response.status == 'error') {
                console.log(response.message);
                return false;
            }
            var hash = response.senderHash; //Hash estará disponível nesta variável.
        });

// Passo 6
// Este passo se aplica apenas se o usuário optou por fazer o pagamento através de Cartão de Crédito.
// Quando o usuário seleciona o método de Cartão de Crédito, precisamos identificar a bandeira do cartão.
        PagSeguroDirectPayment.getBrand({
            cardBin: 411111,
            success: function(response) {
            //bandeira encontrada
            },
            error: function(response) {
            //tratamento do erro
            },
            complete: function(response) {
            //tratamento comum para todas chamadas
            }
        });

// Passo 7
// Este passo se aplica apenas se o usuário optou por fazer o pagamento através de Cartão de Crédito.
//Se você quiser fornecer para o usuário algumas formas de parcelamento, você deverá obtê-las de acordo com o valor total devido.    
        PagSeguroDirectPayment.getInstallments({
            amount: 118.80,
            maxInstallmentNoInterest: 2,
            brand: 'visa',
            success: function(response){
                // Retorna as opções de parcelamento disponíveis
            },
            error: function(response) {
                // callback para chamadas que falharam.
            },
            complete: function(response){
                // Callback para todas chamadas.
            }
        });

//Passo 8
//Este passo se aplica apenas se o usuário optou por fazer o pagamento através de Cartão de Crédito.
//Por motivos de segurança, os dados do cartão não são enviados diretamente na chamada à API. Desta forma, criamos um token para representar o cartão.      
        PagSeguroDirectPayment.createCardToken({
            cardNumber: '4111111111111111', // Número do cartão de crédito
            brand: 'visa', // Bandeira do cartão
            cvv: '013', // CVV do cartão
            expirationMonth: '12', // Mês da expiração do cartão
            expirationYear: '2026', // Ano da expiração do cartão, é necessário os 4 dígitos.
            success: function(response) {
                 var hash = response.senderHash;
                     $(".hashseller").val(hash)
                    // Retorna o cartão tokenizado.
            },
            error: function(response) {
                        // Callback para chamadas que falharam.
            },
            complete: function(response) {
                    // Callback para todas chamadas.
            }
        });

//Passo 9
//Este passo se aplica apenas se o usuário optou por fazer o pagamento através de Cartão de Crédito.
        

             <payment>
                <mode>default</mode>
                <method>creditCard</method>
                <sender>
                    <name>Fulano Silva</name>
                    <email>fulano.silva@uol.com.br</email>
                    <phone>
                        <areaCode>11</areaCode>
                        <number>30380000</number>
                    </phone>
                    <documents>
                        <document>
                            <type>CPF</type>
                            <value>22111944785</value>
                        </document>
                    </documents>
                    <hash>{hash_obtido_no_passo_5}</hash>
                </sender>
                <currency>BRL</currency>
                <notificationURL>https://sualoja.com.br/notificacao</notificationURL>
                <items>
                    <item>
                        <id>1</id>
                        <description>Descricao do item a ser vendido</description>
                        <quantity>1</quantity>
                        <amount>10.00</amount>
                    </item>
                </items>
            <extraAmount>0.00</extraAmount>
                <reference>R123456</reference>
            <shippingAddressRequired>true</shippingAddressRequired>
                <shipping>
                    <address>
                        <street>Av. Brigadeiro Faria Lima</street>
                        <number>1384</number>
                        <complement>1 andar</complement>
                        <district>Jardim Paulistano</district>
                        <city>Sao Paulo</city>
                        <state>SP</state>
                        <country>BRA</country>
                        <postalCode>01452002</postalCode>
                    </address>
                    <type>3</type>
                    <cost>0.00</cost>
                </shipping>
                <creditCard>
                    <token>{creditCard_token_obtido_no_passo_8}</token>
                <installment>
                        <quantity>{quantidade_de_parcelas_escolhida}</quantity>
                        <value>{installmentAmount_obtido_no_retorno_do_passo_7}</value>
                        <noInterestInstallmentQuantity>{valor_maxInstallmentNoInterest_incluido_no_passo_7}
                        </noInterestInstallmentQuantity>
                    </installment>
                    <holder>
                        <name>Nome impresso no cartao</name>
                        <documents>
                            <document>
                                <type>CPF</type>
                                <value>22111944785</value>
                            </document>
                        </documents>
                        <birthDate>20/10/1980</birthDate>
                        <phone>
                            <areaCode>11</areaCode>
                            <number>999991111</number>
                        </phone>
                    </holder>
                    <billingAddress>
                        <street>Av. Brigadeiro Faria Lima</street>
                        <number>1384</number>
                        <complement>1 andar</complement>
                        <district>Jardim Paulistano</district>
                        <city>Sao Paulo</city>
                        <state>SP</state>
                        <country>BRA</country>
                        <postalCode>01452002</postalCode>
                    </billingAddress>
                </creditCard>
            </payment>

           
//  Passo 10
// Este passo se aplica apenas se o usuário optou por fazer o pagamento através de Boleto Bancário.
    
            <payment>
                <mode>default</mode>
                <method>boleto</method>
                <sender>
                    <name>Fulano Silva</name>
                    <email>fulano.silva@uol.com.br</email>
                    <phone>
                        <areaCode>11</areaCode>
                        <number>30380000</number>
                    </phone>
                    <documents>
                        <document>
                            <type>CPF</type>
                            <value>72962940005</value>
                        </document>
                    </documents>
                    <hash>{hash_obtido_no_passo_5}</hash>
                </sender>
                <currency>BRL</currency>
                <notificationURL>https://sualoja.com.br/notificacao</notificationURL>
                <items>
                    <item>
                        <id>1</id>
                        <description>Descricao do item a ser vendido</description>
                        <quantity>2</quantity>
                        <amount>1.00</amount>
                    </item>
                </items>
            <extraAmount>0.00</extraAmount>
                <reference>R123456</reference>
            <shippingAddressRequired>true</shippingAddressRequired>
                <shipping>
                    <address>
                        <street>Av. Brigadeiro Faria Lima</street>
                        <number>1384</number>
                        <complement>1 andar</complement>
                        <district>Jardim Paulistano</district>
                        <city>Sao Paulo</city>
                        <state>SP</state>
                        <country>BRA</country>
                        <postalCode>01452002</postalCode>
                    </address>
                    <type>3</type>
                    <cost>0.00</cost>
                </shipping>
            </payment>

          //  Passo 11
            //Na resposta da requisição de Boleto Bancário, você deve tratar o atributo paymentLink, que conterá o link de acesso ao boleto.
            <transaction>
                <date>2011-02-05T15:46:12.000-02:00</date>  
                <lastEventDate>2011-02-15T17:39:14.000-03:00</lastEventDate>  
                <code>9E884542-81B3-4419-9A75-BCC6FB495EF1</code>  
                <reference>REF1234</reference>  
                <type>1</type>  
                <status>3</status>  
                <paymentMethod>  
                    <type>1</type>  
                    <code>101</code>  
                </paymentMethod>
            <paymentLink>
            https://pagseguro.uol.com.br/checkout/imprimeBoleto.jhtml?code=314601B208B24A5CA53260000F7BB0D
            </paymentLink>
                <grossAmount>49900.00</grossAmount>
                <discountAmount>0.00</discountAmount> 
                <feeAmount>0.00</feeAmount> 
                <netAmount>49900.50</netAmount>  
                <extraAmount>0.00</extraAmount> 
                <installmentCount>1</installmentCount>  
                <itemCount>2</itemCount>  
                <items> 
                    <item>  
                        <id>0001</id>  
                        <description>Notebook Prata</description>  
                        <quantity>1</quantity>  
                        <amount>24300.00</amount>  
                    </item>  
                    <item> 
                        <id>0002</id>  
                        <description>Notebook Rosa</description>  
                        <quantity>1</quantity>  
                        <amount>25600.00</amount>  
                    </item>  
                </items>  
                <sender>  
                    <name>José Comprador</name>  
                    <email>comprador@uol.com.br</email>  
                    <phone>  
                        <areaCode>11</areaCode>  
                        <number>56273440</number>  
                    </phone>  
                </sender>  
                <shipping>  
                    <address>  
                        <street>Av. Brig. Faria Lima</street>  
                        <number>1384</number>  
                        <complement>5o andar</complement>  
                        <district>Jardim Paulistano</district>  
                        <postalCode>01452002</postalCode>  
                        <city>Sao Paulo</city>  
                        <state>SP</state>  
                        <country>BRA</country>  
                    </address>  
                    <type>1</type>  
                    <cost>21.50</cost>  
                </shipping>  
            </transaction>

   
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

