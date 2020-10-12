

    $(window).load(function(){
      
        Iugu.setAccountID("C92CECAE0AB04971898493263536B497");
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
                    var valor_parcelas = $("#parcelas option:selected").val();
                    showToast("Efetuando cobrança... " ,"success");
                    $("#token").val( data.id );
                    $.ajax({
                      type: 'POST',
                      url: '/ajax/ajax.anuais.php',
                      data: {token:data.id,
                            cliente:btn.data('id-cliente'),
                            parcelas:valor_parcelas,
                            vip:btn.data('vip'),
                            valor:btn.data('valor')},
                            success:function(data) {
                              var obj = JSON.parse(data);
                              console.log(obj);
                              
                              if(obj.status==false){
                                showToast("Cobrança não realizada","error");
                                showToast("Codigo de erro:"+ obj.dados, "error");
                              }else{
                                showToast(obj.mensagens,"success");
                              }
                            }
                    })
                
                  }
                  
                  
              }
              $('#pagar').removeAttr('disabled');
              Iugu.createPaymentToken(this, tokenResponseHandler);
              return false;
          });
          
        
            });
          });
        