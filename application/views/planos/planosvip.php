<?
    $clienteLogado = isset($_SESSION['cliente']['id']);
    $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");

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
  <script src="/assets/js/pages/planoiugu.js"></script>
  <script src="/assets/js/pages/planos.js"></script>
  
<?
      echo '<link href="https://www.entendeudireito.com.br/application/views/planos/planos.css" type="text/css" rel="stylesheet" media="screen" />';
?>

  <section  style="height:1100px"class="section-space section ">
    <div style="<? if($cel){
  echo "display:grid;";
  
}?>height:550px;"class="plano  colunas <? if(!$cel){
  echo "center";
  
}?>">
   <!--   <div class="basico plano text-center ">
        <h1>OAB</h1>
        <h2>R$ 29,90</h2>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Suporte via WhatsApp</p>
        <p>Estude Online</p>
        <?php if(isset($_SESSION['cliente']['id'])){ ?>
        <div class="center">
          <div class="final">
            <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu " data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="2" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
            <a class=" " data-id-plano="2" data-vip="0" href="/Checkout?vip=2"> <i class="material-icons cartao ">credit_card</i></a>
          </div>


        </div>
        <?php }else{ ?>
        <div class="center">
          <a class="but final" data-id-plano="1" data-vip="0" href="/login">Assinar Agora!</a>
        </div>
        <?php } ?>
      </div>-->
      <div style="<? if($cel){
  echo "margin-bottom:50px;";
  
}?>" class="oab plano text-center">
        <h1>Básico</h1>
        <h1 class="h1">33% de desconto</h1>
        <h2 class="desconto">De R$ 478,80</h2>
        <h3>12x de R$26,90 durante um ano</h3>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Suporte via WhatsApp</p>
        <p>Estude Online</p>
        
        <div class="center">
          <div style="bottom:-60px !important;" class="<? if(!$cel){echo "final";}?> ">
            <a class="but" href="https://pag.ae/7VGFBizpq">Acesse agora</a>
        </a>
          </div>


        </div>
        
      </div>
      <div class="vip plano text-center">
        <h1>Entendeu</h1>
        <h1 class="h1">25% de desconto</h1>
        <h2 class="desconto">De R$ 958,80</h2>
        <h3>12x de R$59,90 durante um ano</h3>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Estude Online com download de materiais</p>
        <p>Imprima para estudar onde quiser</p>
        <p>Suporte via WhatsApp</p>
        <div class="center ">
          <div style="bottom:-60px !important;"class="<? if(!$cel){
  echo "final";
  
}?> ">
            <a class="but "href="https://pag.ae/7VAxhKCev">Acesse agora</a>
          </div>


        </div>
   
        
      </div>
    </div>
  </section>
  <?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/principal.css" type="text/css" rel="stylesheet" media="screen"/>';
	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/principal.js"></script>';
?>