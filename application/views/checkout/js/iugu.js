

    $(window).load(function(){
      
Iugu.setAccountID("C92CECAE0AB04971898493263536B497");
//Iugu.setTestMode(true);
jQuery(function($) {
  
  $('#payment-form').submit(function(evt) {
    $('#pagar').attr('disabled', 'disabled');
      var form = $(this);
      
      var btn = $(this).find('button[type="submit"]').eq(0);
      var tokenResponseHandler = function(data) {
  
          if (data.errors) {
            if(data.errors.number=="is_invalid"){
              showToast("Verifique o número do cartão" ,"error");
              $('#pagar').removeAttr('disabled');
            }
            else if(data.errors.verification_value=="is_invalid"){
              showToast("Verifique o cvv do cartão","error");
              $('#pagar').removeAttr('disabled');
            }
            else if(data.errors.expiration=="is_invalid"){
              showToast("Verifique a data de expiração do cartão","error");
              $('#pagar').removeAttr('disabled');
            }
            else if(data.errors.first_name=="is_invalid"){
              showToast("Digite o primeiro nome","error");
              $('#pagar').removeAttr('disabled');
            }
            else if(data.errors.last_name=="is_invalid"){
              showToast("Digite o sobrenome","error");
              $('#pagar').removeAttr('disabled');
            }
            else{
              showToast("Erro salvando cartão: " + JSON.stringify(data.errors));
              $('#pagar').removeAttr('disabled');
            }
          } else {
            
            showToast("Efetuando cobrança... " ,"success");
              $("#token").val( data.id );
              $.ajax({
                  type: 'POST',
                  url: '/ajax/ajax.criaassinatura.php?id='+btn.data('id-cliente')+'&vip='+btn.data('vip'),
                  data: {token:data.id},
                  success: function(data) {
                    var obj = JSON.parse(data);
                    console.log(data);
                    var erros = obj.mensagens[0].mensagem.errors;
                    
                    if(obj.mensagens[0].tipo=="success"){
                      showToast("Cobrança efetuada, redirecionando ...","success");
                      //window.location.href="https://www.entendeudireito.com.br/materiais";
                      
                    }
                    else if(!(typeof obj.mensagens[0].mensagem.LR === 'undefined' || obj.mensagens[0].mensagem.LR === null)){
                      showToast("Erro :","error");
                      showToast(obj.mensagens[0].mensagem.errors+", Erro de pagamento:"+obj.mensagens[0].mensagem.LR,"error")
                      $('#pagar').removeAttr('disabled');
                       
                    }
                    else{
                      showToast("Erro(s):","error");
                      const arr = Object.keys(erros).map((key) => [key, erros[key]]);
                      $.each(erros, function( index, value ) {
                        let str=index+value;
                        showToast(str , "error");
                        setTimeout(function(){
                            $toast.fadeOut(4000);
                        }, 5000);
                      });
                      $('#pagar').removeAttr('disabled');
                      window.location.href="https://www.entendeudireito.com.br/materiais";
                    }
                  }
                
              })
          }
          
          
      }
      //eu crio aqui o .$ajax?
      
      Iugu.createPaymentToken(this, tokenResponseHandler);
      return false;
  });
  

    });
  });
