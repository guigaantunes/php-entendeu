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
  
<? if($cel){
      echo '<link href="https://www.entendeudireito.com.br/application/views/planos/mobal.css" type="text/css" rel="stylesheet" media="screen" />';
}else{
      echo '<link href="https://www.entendeudireito.com.br/application/views/planos/planos.css" type="text/css" rel="stylesheet" media="screen" />';
}?>

  <section style="<? echo $pc; ?>"class="section-space section ">
    <div class="plano  colunas center">
      <div class="basico plano text-center ">
        <h1>OAB</h1>
        <h2>R$ 29,90/mês</h2>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Suporte via WhatsApp</p>
        <p>Estude Online</p>
        <?php if(isset($_SESSION['cliente']['id'])){ ?>
        <div class="center">
          <div class="final">
            <a style="margin:0px;color:gray;text-decoration:underline" class="btn-boleto " data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="2" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
            <a class=" " data-id-plano="2" data-vip="0" href="/Checkout?vip=2"> <i class="material-icons cartao ">credit_card</i></a>
          </div>


        </div>
        <?php }else{ ?>
        <div class="center">
          <a class="but final" data-id-plano="1" data-vip="0" href="/login">Assinar Agora!</a>
        </div>
        <?php } ?>
      </div>
      <div class="oab plano text-center">
        <h1>Básico</h1>
        <h2>R$ 39,90/mês</h2>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Suporte via WhatsApp</p>
        <p>Estude Online</p>
        <?php if(isset($_SESSION['cliente']['id'])){ ?>
        <div class="center">
          <div class="final ">
            <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu " data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="1" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
            <a class="  " data-id-plano="1" data-vip="0" href="/Checkout?vip=0">
          <i class="material-icons cartao ">credit_card</i>
        </a>
          </div>


        </div>
        <?php }else{ ?>
        <div class="center">
          <a class="but final " data-id-plano="1" data-vip="0" href="/login">Assinar Agora!</a>
        </div>

        <?php } ?>
      </div>
      <div class="vip plano text-center">
        <h1>Entendeu</h1>
        <h2>R$ 79,90/mês</h2>
        <p>Acesso ilimitado a mais de 1500 esquemas mentais</p>
        <p>Estude Online com download de materiais</p>
        <p>Imprima para estudar aonde quiser</p>
        <p>Suporte via WhatsApp</p>
        <?php if(isset($_SESSION['cliente']['id'])){ ?>
        <div class="center bottomn">
          <div class="final ">
            <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu " data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="0" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
            <a class=" " data-id-plano="1" data-vip="1" href="/Checkout?vip=1">
          <i class="material-icons cartao ">credit_card</i>
        </a>
          </div>


        </div>
        <?php }else{ ?>
        <div class="center">
          <a class="but final" data-id-plano="1" data-vip="0" href="/login">Assinar Agora!</a>
        </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <section style="<? echo $mobal; ?>" id="planos" class="section-space " >
    <h1 class="center" style="color:#ea5312;padding-top:20px;"> Conheça nossos planos e reinvente sua maneira de estudar</h1>
    <div class="plans " style="">
        <div class="plan" style="border-top: 30px solid orange;padding:0px">
            <div class="cabecalho text-center" style="width:100%;padding-top:30px">
                <h1 class="text-orange "style="margin-bottom:10px" >Básico</h1>
                <span style="margin:0px">Limitado</span>
                <p style="margin:0px">Boleto ou Cartão</p>
            </div>
            <div class="center">
                <ul >
                	<li class="center">Acesso ilimitado a mais de 1500</li>
                  <li class="center">esquemas mentais</li>
                	<li class="center">Suporte via WhatsApp</li>
                	<li class="center">Estude Online</li>
                </ul>
            </div>
            <div class="center valor" style="background-color:#e9e9e9 ;width:100%;">
                <h1>R$ 39,90/mês</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px">
                <?php if(isset($_SESSION['cliente']['id'])){ ?>
               <div class="center" style="float:left;padding:1px">
        		    
        			<!--img src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png" width="" height="54px" style="border-radius:12px;padding-right:20px"></img>
    				  <a style ="border-left-width: 0px;position:relative;top:5px;left:-20px;width: 200px; border-top-left-radius:0px !important;border-bottom-left-radius:0px !important;height:54px;font-size:1rem;"class="btn"></a>-->
    				</div>
              
              <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="1" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
                <a class=" " data-id-plano="1" data-vip="0" href="/Checkout?vip=1"><img class="cartao"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png"></a>
                <?php }else{ ?>
                <a class="btn green btn-big green-hover" data-id-plano="1" data-vip="0" href="/login">Assinar Agora!</a>
                <?php } ?>
            </div>
        </div>
        <div class="plan" style="border-top: 30px solid orange;padding:0px">
            <div class="cabecalho text-center" style="width:100%;padding-top:30px">
                <div class="center"><h1 style="margin-bottom:10px;color:#120a8f">O<h1 style="margin-bottom:10px;color:red">AB</h1></h1></div>
                
                <span>Oferta</span>
                <p style="margin:0px">Boleto ou cartão</p>
            </div> 
            <div class="center">
                <ul >
                	<li class="center">Acesso ilimitado a mais de 1500</li>
                  <li class="center">esquemas mentais</li>
                	<li class="center">Suporte via WhatsApp</li>
                	<li class="center">Estude Online</li>
                </ul>
            </div>
            <div class="center valor" style="background-color:#e9e9e9 ;width:100%">
                <h1>R$ 29,90/mês</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px">
                <?php if(isset($_SESSION['cliente']['id'])){ ?>
                  <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="2" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
                <a class="" data-id-plano="2" data-vip="0" href="/Checkout?vip=2"><img class="cartao"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png"></a>
                <?php }else{ ?>
                <a class="btn green btn-big green-hover" data-id-plano="2" data-vip="0" href="/login">Assinar Agora!</a>
                <?php } ?>
            </div>
        </div>
        <div class="plan" style="border-top: 30px solid orange;padding:0px">
            <div class="cabecalho text-center" style="width:100%;padding-top:30px">
                <h1 class="text-orange " style="margin-bottom:10px">Entendeu</h1>
                <span>Recomendado</span>
                <p style="margin:0px">Boleto ou Cartão</p>
               
            </div>
            <div class="center">
                <ul >
                	<li class="center">Acesso ilimitado a mais de 1500</li>
                	<li class="center">esquemas mentais</li>
                	<li class="center">Estude Online com download </li>
                  <li class="center">de materiais</li>
                  <li class="center">Imprima para estudar aonde quiser</li>
                  <li class="center">Suporte via WhatsApp</li>
                </ul>
            </div>
            <div class="center valor" style="background-color:#e9e9e9 ;width:100%">
                <h1>R$ 79,90/mês</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px;padding-top:20px">
                <?php if(isset($_SESSION['cliente']['id'])){ ?>
                  <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="0" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
                <a class=" " data-id-plano="1" data-vip="1" href="/Checkout?vip=2"><img class="cartao"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png"></a>
                <?php }else{ ?>
                <a class="btn green green-hover" data-id-plano="1" data-vip="1" href="/login">Assinar Agora!</a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
  <?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/principal.css" type="text/css" rel="stylesheet" media="screen"/>';
	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/principal.js"></script>';
?>