<script type="text/javascript">
    var agr = new Date();
    var YY = agr.getFullYear();
    var MM = agr.getMonth();
    var DD = agr.getDate();
    var HH = agr.getHours()	;
    var MI = agr.getMinutes()+5;
    var SS = agr.getSeconds();
    function atualizaContador() {
      var hoje = new Date();
      var futuro = new Date(YY, MM, DD, HH, MI, SS);

      var ss = parseInt((futuro - hoje) / 1000);
      var mm = parseInt(ss / 60);
      var hh = parseInt(mm / 60);
      var dd = parseInt(hh / 24);

      ss = ss - (mm * 60);
      mm = mm - (hh * 60);
      hh = hh - (dd * 24);

      var faltam = '';
      faltam += (dd && dd > 1) ? dd + ':' : (dd == 1 ? '1' : '');
      faltam += (toString(hh).length) ? hh + ':' : '';
      faltam += (toString(mm).length) ? mm + ':' : '';
      faltam += ss ;
      if (dd + hh + mm + ss > 0) {
        document.getElementById('contador').innerHTML = faltam;
        setTimeout(atualizaContador, 1000);
      } else {
        document.getElementById('contador').innerHTML = 'Encerrada!!!!';
        setTimeout(atualizaContador, 1000);
      }
    }
</script>
<style>
  @media only screen and (max-width: 480px) {
  .black-week-bonus-tag{
    display:block;
    padding:7px 7px 7px 12px;
    color:white;
    position:relative;
    border-top-right-radius:5px;
    border-bottom-right-radius:5px;
    left:-70px !important;
    font-weight:bold;
    background:red;
    margin-bottom:15px;
    font-size:0.9em
  }
}
  .black-week-bonus-tag{
    display:block;
    padding:7px 7px 7px 12px;
    color:white;
    position:relative;
    border-top-right-radius:5px;
    border-bottom-right-radius:5px;
    left:-8px;
    font-weight:bold;
    background:red;
    margin-bottom:15px;
    font-size:0.9em
  }
  .black-week-bonus-tag:before{
    content:'';
    position:absolute;
    width:0;
    height:0;
    border-style:solid;
    border-width:0 0 7px 8px;
    border-color:transparent transparent gray transparent;
    top:-7px;
    left:0}
  @font-face{
    font-family:relogioicon;
    src:url(../assets/fonts/cont/DS-DIGI.TTF)
  }
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>
<?php
    $classConfiguracao   = new Configuracao;
    $classPlano     = new Plano;
    $classbanner    = new Banner;
    $classBlog      = new Blog;
    
    $configuracoes      = $classConfiguracao->getById(1);
    
    $planos = $classPlano->listarPlanosDisponiveis();
    
    $banners = $classbanner->listar();
    
    $blogs = $classBlog->listar();


    $classConteudo      = new Conteudo;
    $conteudoTermos     = $classConteudo->getById(1);
    $conteudoVantagens  = $classConteudo->getById(3);
    $conteudoPlanos     = $classConteudo->getById(4);
    $conteudoContato    = $classConteudo->getById(5);
    ;
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");

if ($iphone || $ipad || $android || $palmpre || $ipod || $berry ) {
    echo "";
    $verde = 100;
    $slide ='style="width:100%"';
} else {
    $styless=true;
    $verde = 200;
}
?>
<script src="/assets/js/pages/planos.js"></script>
<script src="/assets/js/pages/link.js"></script>
<section class="menor" >
		<div class="left " width="100%"   style="padding:20px;width:100%;background-size: 100% 100%;">
		    <div  style="z-index:2;width:60%;color:white;float:left;display:block;text-size-adjust: auto;<?if($styless){echo"padding-top:100px;padding-bottom:100px;padding-left:100px;padding-right:100px;";}?>">
		        <h1 style="font-size:2em;font-weight: bold" >Aprenda tudo sobre conteúdo jurídico em minutos</h1>
		        <p style="font-size:1em;">Potencialize seu ensino e aprenda 45% mais com o nosso material ilustrativo que fala do jeito que você entende</p>
		        <a style="font-size:1em"class="btn green btn-small green-hover" href="/materiais" >COMECE AGORA</a>
		    </div> 
      <br>
      <div  style="z-index:2;width:40%;float:right;color:white;display:block;text-size-adjust: auto;">
		        <?if($styless){?><img style="width:50%"class="center"src="https://www.entendeudireito.com.br/application/views/principal/Books1.png"><?;}?>
		    </div> 
		</div>
</section>
<section style="padding:0px;background-image: linear-gradient(180deg, #fd7e15 0%, #fc7100 100%);"class="section-space " >
        <div class="plans "style="font-size:20px;color:white;padding:1px;width:85%">
            <div class="center" width="30%" >
                <div>
                    <h2 style="font-weight: bold;">1.500 conteúdos online</h2>
                    <p>Estude maior variedade de assuntos atualizados semanalmente</p>
                </div>
            </div>
            <div class="center" width="30%">
                <div style="padding:10px">
                    <h2 style="font-weight: bold;">Acesse de onde quiser</h2>
                    <p>Materiais sempre disponíveis para acessar quando quiser</p>
                </div>
            </div>
            <div class="center" width="30%">
                <div  style="padding:10px">
                    <h2 style="font-weight: bold;">Feito por quem sabe</h2>
                    <p>Conteúdo criado para facilitar seu estudo</p>
                </div>
            </div>
        </div>
</section>
  <section id="blackpromo" class="section-space " >
    <h1 class="center" style="color:#ea5312;padding-top:20px;"> Conheça nossos planos e reinvente sua maneira de estudar</h1>
    <div class="plans " style="">
<div class="plan" style="border-top: 30px solid #ea5312 ;padding:0px;background-color:black;color:white;height:600px !important">
            <div class="cabecalho text-center" style="width:100%;padding-top:30px">
                <div class="center"><h1 style="margin-bottom:10px;color:#ea5312">	BÁSICO BLACK</h1></div>
                <p style="margin:0px">Via boleto ou cartão</p>
               <p style="margin:0px">em ate 12x</p>
                
            </div> 
            
  <div  class="center">
            <h3 style="text-decoration: line-through;">R$ 39,90 /mês</h3>
        </div>
            <div class="center valor" style="width:100%">
                <h1>R$ 25,00 /mês</h1>
            </div><div class="center" style="color:white" >
                <ul>
                	<li class="text-center"style="color:white">ACESSO ILIMITADO A MAIS DE <br>1500 ESQUEMAS MENTAIS POR 12 MESES</li>
                </ul>
            </div>
  <span class="black-week-bonus-tag">Bônus para os 50 primeiros </span>
            <div class="rodape center" style="padding-bottom:20px">
                <a class="btn green btn-big green-hover btn-pag" data-id-pag="1"  href="#">Assinar Agora!</a>
            </div>
        </div>
      <div class="plan" style="border-top: 30px solid #ea5312 ;padding:0px;background-color:black;height:600px !important">
            <div class="cabecalho text-center" style="width:100%;padding-top:30px;">
                <div class="center"><h1 style="margin-bottom:10px;color:#ea5312">	ENTENDEU BLACK</h1></div>
                <p style="margin:0px;color:white">Via boleto ou cartão</p>
               <p style="margin:0px;color:white">em ate 12x</p>
                
            </div> 
          <div  class="center">
            <h3 style="text-decoration: line-through;color:white;">R$ 79,90 /mês</h3>
        </div>
            <div class="center valor" style="width:100%;color:white;">
                
                <h1>R$ 60,00 /mês</h1>
            </div>
                    <div class="center" style="color:white" >
                <ul>
                	<li class="text-center"style="color:white">ACESSO ILIMITADO A MAIS DE<br> 1500 ESQUEMAS MENTAIS </li>
                	<li class="text-center"style="color:white">IMPRESSÃO E DOWNLOAD DOS<br> MATERIAIS POR 12 MESES</li>
                </ul>
            </div>
        <span class="black-week-bonus-tag">Bônus para os 50 primeiros </span>
            <div class="rodape center" style="padding-bottom:20px">
                <a class="btn green btn-big green-hover btn-pag" data-id-pag="2"  href="#">Assinar Agora!</a>
            </div>
        </div>
      
</section>
<!--<section id="planos" class="section-space " >
    
    <div class="plans " style="">
        <div class="plan" style="border-top: 30px solid orange;padding:0px;height:500px !important">
            <div class="cabecalho text-center" style="width:100%;padding-top:30px">
                <h1 class="text-orange "style="margin-bottom:10px" >Básico</h1>
                <span style="margin:0px">Limitado</span>
                <p style="margin:0px">Somente Cartão</p>
                <a style="margin:0px;color:gray;text-decoration:underline" onclick="aviso()" href="#planos">(Não tem cartão?)</a>
            </div>
            <div class="text-center">
                <ul>
                	<li>UMA BIBLIOTECA COM MAIS DE 1500 CONTEÚDOS</li>
                	<li>ACESSO ILIMITADO</li>
                	<li>MATERIAL DIDÁTICO ONLINE</li>
                </ul>
            </div>
            <div class="center valor" style="background-color:#e9e9e9 ;width:100%;">
                <h1>R$ 39,90 /mês</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px">
                <a class="btn green btn-big green-hover btn-assinar" data-id-plano="1" data-vip="0" href="#">Assinar Agora!</a>
            </div>
        </div>
        <div class="plan" style="border-top: 30px solid orange;padding:0px;height:500px !important">
            <div class="cabecalho text-center" style="width:100%;padding-top:30px">
                <div class="center"><h1 style="margin-bottom:10px;color:#120a8f">O<h1 style="margin-bottom:10px;color:red">AB</h1></h1></div>
                
                <span>Oferta</span>
                <p style="margin:0px">Somente Cartão</p>
                <a style="margin:0px;color:gray;text-decoration:underline" onclick="aviso()" href="#planos">(Não tem cartão?)</a>
            </div> 
            <div class="text-center">
                <ul>
                	<li>UMA BIBLIOTECA COM MAIS DE 1500 CONTEÚDOS</li>
                	<li>ACESSO ILIMITADO</li>
                	<li>MATERIAL DIDÁTICO ONLINE</li>
                </ul>
            </div>
            <div class="center valor" style="background-color:#e9e9e9 ;width:100%">
                <h1>R$ 29,90 /mês</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px">
                <a class="btn green btn-big green-hover btn-assinar" data-id-plano="2" data-vip="0" href="#">Assinar Agora!</a>
            </div>
        </div>
        <div class="plan" style="border-top: 30px solid orange;padding:0px;height:500px !important">
            <div class="cabecalho text-center" style="width:100%;padding-top:30px">
                <h1 class="text-orange " style="margin-bottom:10px">Entendeu</h1>
                <span>Recomendado</span>
                <p style="margin:0px">Somente Cartão</p>
                <a style="margin:0px;color:gray;text-decoration:underline" onclick="aviso()" href="#">(Não tem cartão?)</a>
            </div>
            <div class="text-center" style="width:100%">
                <ul>
                	<li>MAIS DE 1500 CONTEÚDOS</li>
                	<li>ACESSO ILIMITADO</li>
                	<li>MATERIAL DIDÁTICO ONLINE</li>
                	<li>MATERIAL DIDÁTICO OFFLINE</li>
                	<li>IMPRESSÃO E DOWNLOAD DOS MATERIAIS</li>
                </ul>
            </div>
            <div class="center valor" style="background-color:#e9e9e9 ;width:100%">
                <h1>R$ 79,90 /mês</h1>
            </div>
            <div class="rodape center" style="padding-bottom:20px;padding-top:20px">
                	<a class="btn green btn-big green-hover btn-assinar" data-id-plano="1" data-vip="1" href="#">Assinar Agora!</a>
            </div>
        </div>
      
      
    </div>
</section> -->
  
<section class="spaces" style="color:white">
    <div style="background:linear-gradient(to right, #87E034, #44AD13);">
        <h1 style="margin:0px;padding-top:30px"class="text-center">POR QUE A ENTENDEU DIREITO FUNCIONA ?</h1>
    </div>
	    
	<div style="padding:20px"class="vantagens">
	    <div style="padding:20px">
	        <div  class="center">
	            <img width="<?echo $verde?>px" src="<?URL_SITE?>/application/views/principal/b1.png"></img> 
	        </div>
	        <div class="text-center">
    	        <h1>REINVENTE SEU ESTUDO</h1>
    	        <p>Encontre o plano certo que atende tudo que você precisa e não fique para trás na corrida que vai mudar sua vida</p>
	        </div> 
	    </div>
	    <div style="padding:20px;">
	        <div  class="center">
    	        <img width="<?echo $verde?>px"src="<?URL_SITE?>/application/views/principal/b2.png"></img> 
	        </div>
	        <div class="text-center">
    	        <h1>CRIADO POR ESPECIALISTA</h1>
    	        <p>Esquemas mentais criados pela maior especialista em neurolinguística aplicada no direito do Brasil</p>
	        </div> 
	    </div>
	    <div style="padding:20px">
	       <div  class="center">
	            <img width="<?echo $verde?>px"src="<?URL_SITE?>/application/views/principal/b.png"></img> 
	       </div>
	       <div class="text-center">
        	   <h1>CONQUISTE SEU SONHO</h1>
        	   <p>Todo o seu esforço e dedicação convertidos em um resultado, a conquista do seu sonho</p>
    	   </div> 
	    </div>
	</div>
</section>

<section class="section-space">
    
    <h1 style="padding:1rem"class="title text-center">VEM COM A GENTE E GARANTA JÁ SUA VAGA</h1>
    <p class="text-center">Ajudamos a realizar mais de 8.438 sonhos, dá uma olhada no que eles tão falando:</p>
    
    <div class="slideshow-container">
    
    <div class="mySlides fade">
      <div class="numbertext">1 / 8</div>
      <img class="center" <?= $slide?> src="<?PATH_ABSOLUTO?>application/views/principal/1.jpeg" >
    </div>
    
    <div class="mySlides fade">
      <div class="numbertext">2 / 8</div>
      <img class="center" <?= $slide?> src="<?PATH_ABSOLUTO?>application/views/principal/2.jpeg" >
    </div>
    
    <div class="mySlides fade">
      <div class="numbertext">3 / 8</div>
      <img class="center" <?= $slide?> src="<?PATH_ABSOLUTO?>application/views/principal/3.jpeg" >
    </div>
    
    <div class="mySlides fade">
      <div class="numbertext">4 / 8</div>
      <img class="center" <?= $slide?> src="<?PATH_ABSOLUTO?>application/views/principal/5.jpeg" >
    </div>
    
    <div class="mySlides fade">
      <div class="numbertext">5 / 8</div>
      <img class="center" <?= $slide?> src="<?PATH_ABSOLUTO?>application/views/principal/5.jpeg" >
    </div>
    
    <div class="mySlides fade">
      <div class="numbertext">6 / 8</div>
      <img class="center" <?= $slide?> src="<?PATH_ABSOLUTO?>application/views/principal/6.jpeg" >
    </div>
    
    <div class="mySlides fade">
      <div class="numbertext">7 / 8</div>
      <img class="center" <?= $slide?> src="<?PATH_ABSOLUTO?>application/views/principal/7.jpeg" >
    </div>
    
    <div class="mySlides fade">
      <div class="numbertext">8 / 8</div>
      <img class="center" <?= $slide?> src="<?PATH_ABSOLUTO?>application/views/principal/8.jpeg" >
    </div>
    
    
    
    
    </div>
    <br>
    
    <div style="text-align:center">
      <span class="dot"></span> 
      <span class="dot"></span> 
      <span class="dot"></span> 
      <span class="dot"></span> 
      <span class="dot"></span> 
      <span class="dot"></span>
      <span class="dot"></span> 
      <span class="dot"></span>
    </div>
    
    <script>
    var slideIndex = 0;
    showSlides();
    
    function showSlides() {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
      }
      slideIndex++;
      if (slideIndex > slides.length) {slideIndex = 1}    
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
      setTimeout(showSlides, 2000); // Change image every 2 seconds
    }
    </script>
</section>

<section class="section-space">
	<div class="blog" >
		<div class="section-name">
		<a class="title text-orange text-left">Últimas do Blog</a>
		</div>
		<div class="noticias" >
			<div class="swiper-container swiper-blog">
			    <!-- Additional required wrapper -->
			    <div class="swiper-wrapper">
			        <!-- Slides -->
			        <?foreach($blogs as $i => $blog):
			        if($i<10):?>
	            <div class="noticia swiper-slide" style="border:solid  orange 10px;border-radius:20px;padding:10px">
		            <div class="content-noticia">
	    						<a class="titulo-noticia"><?=$blog['titulo']?><br></a>
	    						<span class="infos-noticia"><?=ucfirst($blog['data_formatada'])?> | <?=$blog['autor']?></span>
	    						<p class="conteudo-noticia"><?=( strlen(semHtml($blog['conteudo'])) > 300 ? substr(semHtml($blog['conteudo']),0, 300).'...' : semHtml($blog['conteudo']) )?></p>
    						</div>
    						<div class="direita" style="float:right">
    							<a href="/conteudo/<?=$blog['url']?>" class="btn green btn-small green-hover" style="height:31px">Ver matéria completa</a>
    						</div>
    					</div>
			      <?endif;
			        endforeach;?>
			    </div>	
			</div>
		</div>
		<div class="swiper-pagination bullets"></div>
	</div>
</section>

<section class="section-space">
	<div >
		<div class="plans contato center">
		    <div><h1 style="margin-right:200px;float:left;float:top;<?if($styless){echo "position:relative;top:-100px";}?>" class="title">FALE <br> CONOSCO</h1></div>
			<div  class="half-size">
			<form style="<?if($styless){echo"width:600px";}?>;margin-top:20px"   class="form" id='form-login' action="/ajax/ajax.contato.php" method="POST">
				<div class="input-field required" data-error="Informe seu nome">
	    			<input id="nome" type="text" name="nome" placeholder="Nome" class="required" value="<?=( isset($_SESSION['admin']['id']) ? $_SESSION['cliente']['nome'] : '')?>" />
	    		</div>
	    		<div class="input-field required" data-error="Informe seu email">
	    			<input id="email" type="text" name="email" placeholder="E-mail" class="required" value="<?=( isset($_SESSION['admin']['id']) ? $_SESSION['cliente']['email'] : '')?>"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe seu telefone">
	    			<input id="telefone" type="text" name="telefone" placeholder="Telefone" class="required" value="<?=( isset($_SESSION['admin']['id']) ? $_SESSION['cliente']['telefone'] : '')?>"/>
	    		</div>
	    		<div class="input-field">
					<textarea id="msg" type="text" name="msg" placeholder="Mensagem" rows="1" oninput='if(this.scrollHeight > this.offsetHeight && this.rows < 4) this.rows += 1'></textarea>
				</div>
	    		<div class="input-field required" >
		    		<a href="javascript:void(0)" class="btn btn-send" id='btn-send'>enviar</a>
	    		</div>
	    		<div class="enviar">
    				<button type="submit" class="btn gray btn-small gray-hover">Enviar Mensagem</button>
    			</div>
			</form>
			<div class="flex">
				<div class="flex center">
					    <a href="https://www.facebook.com/Entendeudireito/" target="_blank"><img src="https://logodownload.org/wp-content/uploads/2014/09/facebook-logo-2-1.png" style="width:50px;"></a>
					    <a href="https://api.whatsapp.com/send?phone=556791295622&text=Ol%C3%A1%2C%20vim%20pela%20p%C3%A1gina%20de%20contato" target="_blank"><img src="https://logodownload.org/wp-content/uploads/2015/04/whatsapp-logo-1.png"style="width:50px;"></img></a>
					    <a href="https://www.instagram.com/entendeudireito/" target="_blank"><img src="https://logodownload.org/wp-content/uploads/2017/04/instagram-logo.png"style="width:50px;"></i></a>
				</div>
			</div>
			</div>
		</div>
	</div>
</section>
<script>
    function aviso() {
        decisao = confirm("Não possui cartão de crédito? Entre em contato com nossa página de contato, Chat ou através do nosso WhatsApp (67)991295622 que tentamos dar um jeitinho!");
        return false;
    }
 </script>
<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/principal.css" type="text/css" rel="stylesheet" media="screen"/>';
	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/principal.js"></script>';
?>