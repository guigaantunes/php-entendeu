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

    <section style="height:1100px" class="section-space section ">
      <div style="<? if($cel){echo " display:grid; ";}?>height:520px;"class="plano  colunas <? if(!$cel){echo " center ";}?>">
        <div style="<? if($cel){echo " margin-bottom:50px; ";}?>" class="vip plano text-center">
          <h1>Básico Anual</h1>
          <h2>R$29,90</h2>
          <h3>12 meses de acesso</h3>
          <p>12x no cartão sem juros</p>
          <p>Acesso a mais de 1500 mapas mentais</p>
          <p>Conteúdo novo toda semana</p>


          <div class="final ">
            <a class="but" href="https://pag.ae/7VGFBizpq">Acesse agora</a>
          </div>



        </div>
        <div style="<? if($cel){echo " margin-bottom:50px; ";}?>" class="oab plano text-center">
          <h1>Básico </h1>
          <h2>R$39,90</h2>
          <h3>1 mes de acesso</h3>
          <p class="no-margin">(renovação automática)</p>
          <p>Cartão de crédito ou boleto bancário;</p>
          <p>Acesso a mais de 1500 mapas mentais</p>
          <p>Conteúdo novo toda semana</p>

          <div class="final ">
            <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu " data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="1" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
            <a class="  " data-id-plano="1" data-vip="0" href="/Checkout?vip=0"><i class="material-icons cartao ">credit_card</i> </a>
          </div>

        </div>

        <div <? if($cel){echo 'style="display:none;" ';}?>class="linha-vertical">

        </div>
        <div style="<? if($cel){echo " margin-bottom:50px; ";}?>" class="vip plano text-center">
          <h1>Entendeu Anual</h1>
          <h2>R$59,90</h2>
          <h3>12 meses de acesso</h3>
          <p>12x no cartão sem juros</p>
          <p>Acesso a mais de 1500 mapas mentais</p>
          <p>Conteúdo novo toda semana</p>
          <p>Impressões ilimitadas</p>


          <div class="final ">
            <a class="but" href="https://pag.ae/7VH3UjJ7K">Acesse agora</a></a>
          </div>

        </div>
        <div class="oab plano text-center">
          <h1>Entendeu </h1>
          <h2>R$79,90</h2>
          <h3>1 mes de acesso</h3>
          <p class="no-margin">(renovação automática)</p>
          <p>Cartão de crédito ou boleto bancário</p>
          <p>Acesso a mais de 1500 mapas mentais</p>
          <p>Conteúdo novo toda semana</p>
          <p>Impressões ilimitadas</p>
          <div class="final ">
            <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu " data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="0" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
            <a class=" " data-id-plano="1" data-vip="1" href="/Checkout?vip=1"><i class="material-icons cartao ">credit_card</i></a>
          </div>


        </div>
      </div>
    </section>
    <?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/principal.css" type="text/css" rel="stylesheet" media="screen"/>';
	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/principal.js"></script>';
?>