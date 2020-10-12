<?  
    if ( !isset($_SESSION['cliente']['id']) ) {
      echo "<script>window.location.href = '/login'</script>";
  }
    $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
    $vip = $_GET["vip"];
    if($vip == 1){
      $valor =358.80;
      $valor1=358.80;
    }
    else if($vip== 2){
      $valor = 718.80;
      $valor1= 718.80;
    } 
    else if($vip==3){
      $valor = 610.90;
      $valor1= 610.90;
    }
    elseif($vip==4){
      $valor= 304.90;
      $valor1=304.90;
    }
    elseif($vip==5){
      $valor= 238.80;
      $valor1=238.80;
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
<link href="https://entendeudireito.com.br/application/views/checkout/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="https://entendeudireito.com.br/application/views/checkout/css/creditly.css" type="text/css" media="all" />
<link rel="stylesheet" href="https://entendeudireito.com.br/application/views/checkout/css/easy-responsive-tabs.css">
<link rel="stylesheet" href="https://entendeudireito.com.br/application/views/checkout/css/iugu.css">
<link rel="stylesheet" href="https://entendeudireito.com.br/application/views/checkout/css/planoss.css">
<script src="https://entendeudireito.com.br/application/views/checkout/js/jquery.min.js"></script>
<script src="https://entendeudireito.com.br/application/views/checkout/js/anuais.js"></script>
<script src="https://entendeudireito.com.br/application/views/checkout/js/trocadevalor.js"></script>
<script src="https://entendeudireito.com.br/application/views/checkout/js/cupom.js"></script>


<script type="text/javascript" src="https://js.iugu.com/v2"></script>
<link href="//fonts.googleapis.com/css?family=Overpass:100,100i,200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<link href='https://entendeudireito.com.br/application/views/planos/planoss.css' rel='stylesheet' type='text/css'>

<body>
  <div class="main <?if(!$cel){ echo " center ";}?>">
    <div class="">
      <ul style=" <?if(!$cel){ echo " width:400px; ";}?>"class="pricing-list bounce-invert <? if($cel){ echo " center ";} ?>">
        <li style=" <?if(!$cel){ echo " width:400px; ";}?>" class="exclusive">
          <ul class="pricing-wrapper">
            <?if($_GET['vip']==2){?>
              <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">54,
							90</span> <span class="duration1">12</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 ano de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Impressões ilimitadas;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
              
            </li>
            <?}
             elseif($_GET['vip']==1){ ?>
              <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">29,
							90</span> <span class="duration1">12</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 ano de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white"> only</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
              
            </li>
            <?}elseif($_GET['vip']==3){?>
              <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">50,90</span> <span class="duration1">12</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 ano de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Impressões ilimitadas;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white"> only</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
            
            <?}elseif($_GET['vip']==4){?>
              <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">25,40</span> <span class="duration1">12</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 ano de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white"> only</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
            
            <?}elseif($_GET['vip']==5){?>
              <li data-type="monthly" class="is-visible">
              <header class="pricing-header">
                <h2>Entendeu</h2>
                <div class="price"> <span class="currency">R$</span> <span class="value">19,90</span> <span class="duration1">12</span>
                </div>
              </header>
              <div class="pricing-body">
                <ul class="pricing-features">
                  <li> 1 ano de acesso;</li>
                  <li> Acesso a mais de 1500 mapas mentais;</li>
                  <li> Conteudo novo toda semana;</li>
                  <li> Suporte via whatsapp;</li>
                  <li style="color:white"> only</li>
                  <li style="color:white"> only</li>
                </ul>
              </div>
            
            <?}?>
          </ul>
        </li>
      </ul>
    </div>
    <div class="w3_agile_main_grids no-margin " style ="<?if($cel){ echo " width:100%; ";} ?>border: 1px solid #ff6f3c">
      <div class="agile_main_top_grid">
        <div class="agileits_w3layouts_main_top_grid_left">
          <a href="/planosnovo"><img src="https://entendeudireito.com.br/application/views/checkout/images/1.png" alt=" " /></a>
        </div>
        <div class="w3_agileits_main_top_grid_right">
          <h3>Pagamento</h3>
        </div>
        <div class="clear"> </div>
        <div class="wthree_total">
          <h2><i>R$</i><span id="valor"><?=number_format($valor, 2, ',', '')?></span></h2>
        </div>
      </div>
      <div class="agileinfo_main_bottom_grid">
        <div id="horizontalTab">
          <ul class="resp-tabs-list">
            <li style="display:none"class="center"><img src="https://entendeudireito.com.br/application/views/checkout/images/1.jpg" alt=" cartao" /></li>
          </ul>
          <div class="resp-tabs-container">
            <div class="agileits_w3layouts_tab1 "style="display:block">
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
                  
                  <select id="parcelas"onchange="trocavalores()" style="margin-top:20px">
                    <?
                    for($i=1;$i<=12;$i++){
                      $valor_parcela= $valor/$i;
                      $valor_parcela=number_format($valor_parcela, 2, ',', '');
                      /*if($i%2!=0){
                        $valor_parcela -=0.01;
                      }*/
                      if($i!=12){
                        
                        echo '<option style="font-size:1em" value="'.$i.'">'.$i.'x <span id="valor_total">'.$valor_parcela.'</span> sem juros</option>';
                      }
                      else{
                        echo '<option style="font-size:1em" value="'.$i.'"selected>'.$i.'x <span id="valor_total">'.$valor_parcela.'</span> sem juros</option>';
                      }
                    }
                    ?>
                    
                  </select>
                

                <div class="center">
                  <footer class="pricing-footer"> <button class="select" href="#" id="pagar" data-valor="<?=$valor1?>"data-parcela="12" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="<?=$vip?>" type="submit">Pagar</button> </footer>
                  
                </div>
                <p >Possui um cupom? Aplique ele aqui!</p>
                  <input  style="background-color:#d3d3d3"id="nome" type="text" name="cupom" value="">
                  <button  href="java" onclick="cupomAnuais()" id="verificar" >verificar</button>
                  <p class="resposta"></p>
              </form>
            </div>
          </div>  
        </div>
      </div>
    </div>
   
  </div>
  <!-- tabs -->
  <script src="https://entendeudireito.com.br/application/views/checkout/js/easy-responsive-tabs.js"></script>
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