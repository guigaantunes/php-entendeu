<?php
    
    $classPlano     = new Plano;

    /*if ( !isset($_SESSION['cliente']['id']) ){
        echo "<script>window.location.href = '/login?login=1'</script>";
    }
/*
    $planos = $classPlano->getBy(
        $dados = array(
            'status' => 1
        ),
        $campos = array(
            '*'
        ),
        $inner  = false,
        $left   = false,
        $groupBy= false,
        $having = false,
        $orderBy= 'ordem ASC'
    );
*/  
    
    $planos = $classPlano->listarPlanosDisponiveis();
        
    $classConteudo      = new Conteudo;
    $conteudoPlanos     = $classConteudo->getById(4);
    
    $clienteLogado = isset($_SESSION['cliente']['id']);
    
?>
<style>
  .plan{
    width: 300px !important;
		height: 550px !important;
  }
  .cartao{
    width:75px;
    margin:50px;
  }
  .boleto{
    width:100px;
  }
</style>
  <script src="/assets/js/pages/planoiugu.js"></script>
  <script src="/assets/js/pages/planos.js"></script>
  <section class="center navigation">
    <div class="menor navigation-bar text-left">
      <a class="page-name">Planos</a>
      <a class="page-name nav-separator"> | </a>
      <div class="page-path">
        <a href="/" class="select-hover">Home</a> >
        <a class="select-hover">Planos</a>

      </div>
    </div>
  </section>

  <section id="planos" class="section-space " >
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
                <h1>R$ 39,90</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px">
                <?php if(isset($_SESSION['cliente']['id'])){ ?>
               <div class="center" style="float:left;padding:1px">
        		    
        			<!--img src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png" width="" height="54px" style="border-radius:12px;padding-right:20px"></img>
    				  <a style ="border-left-width: 0px;position:relative;top:5px;left:-20px;width: 200px; border-top-left-radius:0px !important;border-bottom-left-radius:0px !important;height:54px;font-size:1rem;"class="btn"></a>-->
    				</div>
              
              <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="1" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
                <a class=" btn-assinar" data-id-plano="1" data-vip="0" href="#"><img class="cartao"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png"></a>
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
                <h1>R$ 29,90</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px">
                <?php if(isset($_SESSION['cliente']['id'])){ ?>
                  <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="2" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
                <a class=" btn-assinar" data-id-plano="2" data-vip="0" href="#"><img class="cartao"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png"></a>
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
                <h1>R$ 79,90</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px;padding-top:20px">
                <?php if(isset($_SESSION['cliente']['id'])){ ?>
                  <a style="margin:0px;color:gray;text-decoration:underline" class="btn-iugu" data-id-cliente="<?=$_SESSION['cliente']['id']?>" data-vip="0" href="#"><img class="boleto"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/boleto.png"></a>
                <a class=" btn-assinar" data-id-plano="1" data-vip="1" href="#"><img class="cartao"src="https://www.entendeudireito.com.br/application/views/pagamento_iugu/cartao.png"></a>
                <?php }else{ ?>
                <a class="btn green green-hover" data-id-plano="1" data-vip="1" href="/login">Assinar Agora!</a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
  </div>
  </div>

  <?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/principal.css" type="text/css" rel="stylesheet" media="screen"/>';
	//$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/planoiugu.js"></script>';
?>