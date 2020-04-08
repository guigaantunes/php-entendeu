$(document).on('click', '.btn-iug', function() {
    let idCliente = $(this).data('id-cliente');
    let vip = $(this).data('vip');
    if (idCliente == "") {
              window.location.href="https://www.entendeudireito.com.br/login?login=1";
    }
    else{
    $.ajax({
        method: 'POST',
        url: '/ajax/ajax.iugu.php',
        data: {id: idCliente},
        //redirect: '/minha-conta',
        
        success: function(data) {
          
          var obj = JSON.parse(data);
          console.log(obj.mensagens[0].errors);
          var erros = obj.mensagens[0].mensagem.errors;
          if(obj.mensagens[0].tipo=="success"){
            showToast("Cadastro completo, gerando boleto", "success");
            window.location.href="https://www.entendeudireito.com.br/criarplano?id="+idCliente+"&vip="+vip;
          }
          
          else{
          	showToast("erro");
            const arr = Object.keys(erros).map((key) => [key, erros[key]]);
            $.each(erros, function( index, value ) {
              showToast(index+" "+value,"error");
              setTimeout(function(){
                  $toast.fadeOut(4000);
              }, 5000);
            });
            sleep(5000);
            window.location.href="https://www.entendeudireito.com.br/minha-conta";
          }
         	
            
        }
    })
          }
    
});