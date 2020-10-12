

    function cupom(){
        $(".resposta #append").remove();
        let cupom = $("input[type=text][name=cupom]").val();
        $.ajax({
          type: 'POST',
          url: '/ajax/ajax.validacupom.php',
          data: 'token='+cupom,
          success: function (result) {
            var obj = JSON.parse(result);
            var plano = obj.mensagens[0].mensagem;
            if(plano!= false){
                showToast("Cupom inserido com sucesso, o valor sera alterado na fatura não se preocupe.", "success");
                $(".resposta").append('<i id="append"style="color:green"class="material-icons">check_circle</p>');
                $("#pagar").attr("data-vip",plano);
                $(".btn-iug").attr("data-vip",plano);
            }
            else{
              showToast("Não conseguirmos achar seu cupom :(", "error");
                $(".resposta").append('<i id="append"style="color:red"class="material-icons">error</p>');
            }
          }
        });
    }
    function cupomAnuais(){
      $(".resposta #append").remove();
      let cupom = $("input[type=text][name=cupom]").val();
      if(cupom=="QC15ENTENDEU"){
        window.location.href="https://entendeudireito.com.br/anuais?vip=3";
      }
      else if (cupom=="QC15BASICO"){
        window.location.href="https://entendeudireito.com.br/anuais?vip=4";
      }
      else if (cupom=="EDSOCIAL"){
        window.location.href="https://entendeudireito.com.br/anuais?vip=5";
      }
  }
    

