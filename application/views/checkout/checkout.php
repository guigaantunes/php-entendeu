<?  if ( !isset($_SESSION['cliente']['id']) ) {
        echo "<script>window.location.href = '/login?planos=vip'</script>";
    }


    $clienteLogado = isset($_SESSION['cliente']['id']);
    $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
$vip = $_GET["vip"];
if($vip == 1){
  $valor = "79,90";
}
else if($vip == 0){
  $valor = "39,90";
}
else if($vip == 2){
  $valor = "24,90";
}
else if($vip == 3){
  $valor = "54,90";
}
if ($iphone || $ipad || $android || $palmpre || $ipod || $berry ) {
    $mobal =  "";
    $pc = "display:none";
  $cel= true;
} else {
    $pc =  "";
    $mobal = "display:none";
  $cel=false;
}
?>
<script type="application/x-javascript">
  addEventListener("load", function() {
    setTimeout(hideURLbar, 0);
  }, false);

  function hideURLbar() {
    window.scrollTo(0, 1);
  }
  
</script>
<script src="/assets/js/pages/planoiugu.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/formatter.js/0.1.5/formatter.min.js"></script>
<!-- //custom-theme -->
<link href="https://www.entendeudireito.com.br/application/views/checkout/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="https://www.entendeudireito.com.br/application/views/checkout/css/creditly.css" type="text/css" media="all" />
<link rel="stylesheet" href="https://www.entendeudireito.com.br/application/views/checkout/css/easy-responsive-tabs.css">
<link rel="stylesheet" href="https://www.entendeudireito.com.br/application/views/checkout/css/iugu.css">
<link rel="stylesheet" href="https://www.entendeudireito.com.br/application/views/checkout/css/planoss.css">
<script src="https://www.entendeudireito.com.br/application/views/checkout/js/jquery.min.js"></script>
<script type="text/javascript" src="https://js.iugu.com/v2"></script>
<script src="https://www.entendeudireito.com.br/application/views/checkout/js/iugu.js"></script>
<link href="//fonts.googleapis.com/css?family=Overpass:100,100i,200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<link href='https://www.entendeudireito.com.br/application/views/planos/planoss.css' rel='stylesheet' type='text/css'>

<body>
  <div class="main <?if(!$cel){ echo " center ";}?>">
    <div class="">
      <ul style="<? if(!$cel){ echo " width:400px; ";} ?>"class="pricing-list bounce-invert <? if($cel){ echo " center ";} ?>">
        <li style="<? if(!$cel){ echo " width:400px; ";} ?>" class="exclusive">
          <ul class="pricing-wrapper">
            <? if($vip==0){
                ?>
            <li data-type="monthly" class="is-visible is-ended">
              <header class="pricing-header">
                <h2>Básico</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">39,
                        90</span> <span class="duration">mês</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 mês de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white">only</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
              <footer class="pricing-footer"> <a class="select" href="https://www.entendeudireito.com.br/checkout?vip=0">Assine</a> </footer>
            </li>
            <?
            }
            else if($vip=="1"){
              ?>
            <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">79,
							90</span> <span class="duration">mês</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 mês de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Impressões ilimitadas;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
              
            </li>
            <?
            } 
            else if($vip=="2"){
                ?>
            <li data-type="monthly" class="is-visible is-ended">
              <header class="pricing-header">
                <h2>Básico</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">24,
                        90</span> <span class="duration">mês</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 mês de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white">only</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
            <?
            }
            else if($vip=="3"){
                ?>
            <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">54,
							90</span> <span class="duration">mês</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 mês de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Impressões ilimitadas;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
              
            </li>
            <?
            }?>
          </ul>
        </li>
      </ul>
    </div>
    <div class="w3_agile_main_grids no-margin " style="<? if($cel){ echo " width:100%; ";} ?>border: 1px solid #ff6f3c">
      <div class="agile_main_top_grid">
        <div class="agileits_w3layouts_main_top_grid_left">
          <a href="/planosnovo"><img src="https://www.entendeudireito.com.br/application/views/checkout/images/1.png" alt=" " /></a>
        </div>
        <div class="w3_agileits_main_top_grid_right">
          <h3>Pagamento</h3>
        </div>
        <div class="clear"> </div>
        <div class="wthree_total">
          <h2><span><i>R$</i><?=$valor?></span></h2>
        </div>
      </div>
      <div class="agileinfo_main_bottom_grid">
        <div id="horizontalTab">
          <ul class="resp-tabs-list">
            <li><img src="https://www.entendeudireito.com.br/application/views/checkout/images/1.jpg" alt=" cartao" /></li>
            <li><img src="https://www.entendeudireito.com.br/application/views/checkout/images/2.jpg" width="70" height="20" alt="boleto " /></li>
          </ul>
          <div class="resp-tabs-container">
            <div class="agileits_w3layouts_tab1">
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
                  
                </div>
                <div class="token-area " style="display:none">
                  <label for="token">Token do Cartão de Crédito - Enviar para seu Servidor</label>
                  <input type="text"  name="token" id="token" value="" readonly="true" size="64" style="text-align:center" />
                </div>


                <div class="center">
                  <footer class="pricing-footer"> <button class="select" href="#" id="pagar" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="<?=$vip?>" type="submit">Pagar</button> </footer>
                  
                </div>
              </form>
            </div>
            <div class="agileits_w3layouts_tab2">
              <div id="divDebito" style="margin-top:50px">
                <div class="center">
                  <a class="select center btn-iug " style="cursor:pointer"data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="<?=$vip?>" > <span class="center">Emitir Boleto</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="display:none" class="agileits_copyright">
      <p>© 2017 Fascinating Checkout Form. All rights reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a></p>
    </div>
  </div>
  <!-- tabs -->
  <script src="https://www.entendeudireito.com.br/application/views/checkout/js/easy-responsive-tabs.js"></script>
  <script>
    $(document).ready(function() {
      $('#horizontalTab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion           
        width: 'auto', //auto or any width like 600px
        fit: true, // 100% fit in a container
        closed: 'accordion', // Start closed if in accordion view
        activate: function(event) { // Callback function if tab is switched
          var $tab = $(this);
          var $info = $('#tabInfo');
          var $name = $('span', $info);
          $name.text($tab.text());
          $info.show();
        }
      });
    });
  </script>
  <!-- //tabs -->
</body>

</html>