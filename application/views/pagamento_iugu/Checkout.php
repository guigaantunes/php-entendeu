<?php
//echo isset($_SESSION['cliente']['id']);
    if ( !isset($_SESSION['cliente']['id']) ){
      if(!array_key_exists("vip",$_GET)){
        echo "<script>window.location.href = '/login?login=1'</script>";
      }
    }
    
    $clienteLogado = isset($_SESSION['cliente']['id']);
    $vip = $_GET["vip"];
    echo $_GET["vip"];

?>
  <link href="https://www.entendeudireito.com.br/application/views/planos/planos.css" type="text/css" rel="stylesheet" media="screen" />
  <link rel="stylesheet" type="text/css" href="https://www.entendeudireito.com.br/application/views/pagamento_iugu/iugu.css">

  <script type="text/javascript" src="https://js.iugu.com/v2"></script>
  <script type="text/javascript" src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/iugu.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/formatter.js/0.1.5/formatter.min.js"></script>
  <script src="/assets/js/pages/planoiugu.js"></script>
  <script type="text/javascript">
    function radio(id) {
      var radio = id;
      if (radio == "1") {
        document.getElementById("divCredito").style.display = 'flex';
        document.getElementById("divCredito").style.display = 'flex';
        document.getElementById("divDebito").style.display = 'none';
      } else if (radio == "2") {
        document.getElementById("divCredito").style.display = 'none';
        document.getElementById("divCredito").style.display = 'none';
        document.getElementById("divDebito").style.display = 'flex';
      }
    }
  </script>
  <form class=" " id="combo" >
    <div class=" center botaoCredito">
      <input type="radio" checked="checked" class="btn-selected" name="inputr" onclick="radio(1);" data-id-value="Credito"> Cartão
    </div>
    <!-- <div class=" center botaoDebito">
      <input  type="radio" class="btn-selected" name="inputr" onclick="radio(2);" data-id-value="Debito"> Boleto
    </div>--> 
  </form>
<div class="rowe row">
  
<div style="width:50%" class="center">
  
  
<?php 
  echo $vip;
if($vip=="0"){?>
    <div style ="width:50%;height:100%;box-shadow: none;border-width: medium;border-style: solid; border-color: #ED6726;border-radius:30px"class="basico plano text-center pad">
        <h1>Basico</h1>
        <h2>R$ 39,90</h2>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Suporte via WhatsApp</p>
        <p>Estude Online</p>
        
      </div>
    <?php }
      else if($vip=="2"){?>
    <div style ="width:50%;height:100%;box-shadow: none;border-width: medium;border-style: solid; border-color: #ED6726;border-radius:30px" class="basico plano text-center pad">
        <h1>OAB</h1>
        <h2>R$ 29,90</h2>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Suporte via WhatsApp</p>
        <p>Estude Online</p>
</div>
    <?php }
      else if($vip=="1"){?>
    <div  style ="width:50%;height:100%;box-shadow: none;border-width: medium;border-style: solid; border-color: #ED6726;border-radius:30px" class="vip plano text-center pad">
        <h1>Entendeu</h1>
        <h2>R$ 79,90</h2>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Estude Online com download de materiais</p>
        <p>Imprima para estudar aonde quiser</p>
        <p>Suporte via WhatsApp</p>
      </div>

    <?php }?>
    <?php }
      else if($vip=="3"){?>
    <div  style ="width:50%;height:100%;box-shadow: none;border-width: medium;border-style: solid; border-color: #ED6726;border-radius:30px" class="vip plano text-center pad">
        <h1>Entendeu</h1>
        <h2>R$ 59,90</h2>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Estude Online com download de materiais</p>
        <p>Imprima para estudar aonde quiser</p>
        <p>Suporte via WhatsApp</p>
      </div>

    <?php }?>
  </div>

  <div style ="width:50%;"class=" bordaPag  " id="divCredito" style="display:flex">

    <div style="width:200px;" class="iugu ">
      <form id="payment-form" action="javascript:void(0);" method="POST">
        <div class="usable-creditcard-form">
          <div class="wrapper center">
            <div class="input-group nmb_a">
              <div class="icon ccic-brand"></div>
              <input autocomplete="off" class="credit_card_number" data-iugu="number" placeholder="Número do Cartão" type="text" value="">
            </div>
            <div class="input-group nmb_b">
              <div class="icon ccic-cvv"></div>
              <input autocomplete="off" class="credit_card_cvv" data-iugu="verification_value" placeholder="CVV" type="text" value="">
            </div>
            <div class="input-group nmb_c">
              <div class="icon ccic-name"></div>
              <input class="credit_card_name" data-iugu="full_name" placeholder="Titular do Cartão" type="text" value="">
            </div>
            <div class="input-group nmb_d">
              <div class="icon ccic-exp"></div>
              <input autocomplete="off" class="credit_card_expiration" data-iugu="expiration" placeholder="MM/AA" type="text" value="">
            </div>
          </div>
          <div class="footer">
            <img src="http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/cc-icons.e8f4c6b4db3cc0869fa93ad535acbfe7.png" alt="Visa, Master, Diners. Amex" border="0">
            <a class="iugu-btn" href="http://iugu.com" tabindex="-1"><img src="http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/payments-by-iugu.1df7caaf6958f1b5774579fa807b5e7f.png" alt="Pagamentos por Iugu" border="0"></a>
          </div>
        </div>
        <div class="token-area " style="<? if($_GET['dev']!="1"){echo  "display:none";}?>">
          <label for="token">Token do Cartão de Crédito - Enviar para seu Servidor</label>
          <input type="text" name="token" id="token" value="" readonly="true" size="64" style="text-align:center" />
        </div>


        <div class="center">
          <button id="pagar" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="<?=$vip?>" type="submit">Salvar</button>
        </div>
      </form>
    </div>
    </div>
  </div>
  <div id="divDebito" style="display:none;margin-top:50px">
    <div class="center"style="cursor:pointer!important">
      <a class="btn green center btn-iugu " style="cursor:pointer"data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="<?=$vip?>" href="#" > Emitir Boleto</a>
    </div>
  </div>
  <?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/principal.css" type="text/css" rel="stylesheet" media="screen"/>';
	//$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/principal.js"></script>';
?>