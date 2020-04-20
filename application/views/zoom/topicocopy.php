<?php

//$Pagseguro          = new Pagseguro;
$classCliente    = new Cliente;
$class           = new MaterialEstudo;
$classLido       = new ClienteLeuMaterial;
$classAssinatura = new Assinatura;
require_once(PATH_ABSOLUTO . "application/controller/iugu.php");
$classIugu = new Iugu;

$e = $classIugu->temAssinatura($_SESSION['cliente']['id']);
if ($e == false) {
    $acesso = 0;
} else if ($e == "plano_basico" || $e == "plano_oab") {
    $acesso = 1;
} else {
    $acesso = 2;
}
$cliente = $classCliente->getbyId($_SESSION['cliente']['id']);

$id       = $this->parametros[1];
$conteudo = $class->getById($id);

$imagem = $class->getImages($id);

$arquivo = $class->getFiles($id);
$arquivo = end($arquivo);

$conteudoLido = $classLido->materialLido($id);
$video        = $conteudo['video'];
$idVideo      = soNumero($video);
$html         = '<iframe src="https://player.vimeo.com/video/' . $idVideo . '"frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

$assinatura = $classAssinatura->getAssinatura();



if ($_REQUEST['teste'] == 'sim') {
    $teste1 = $classAssinatura->temAcessoBasico(709);
    echo "<pre>Cliente 709 => " . print_r($teste1, true);
}
if (isset($cliente["data1ano"]) && $cliente["data1ano"] != "0000-00-00") {
    if (strtotime($cliente["data1ano"]) >= strtotime(date("Y-m-d"))) {
        $liberado1ano = true;
        if ($cliente["vip"] == 1) {
            $vip1ano = true;
        } else {
            $vip1ano = false;
        }
    } else {
        $liberado1ano = false;
    }
    echo $vip1ano;
}




//echo "1".$_SESSION['cliente']['id'];
?>
<body>


<style>
		
		/* these styles are for the demo, but are not required for the plugin */
		.zoom {
			display:inline-block;
			position: relative;
		}
		
		/* magnifying glass icon */
		.zoom:after {
			content:'';
			display:block; 
			width:33px; 
			height:33px; 
			position:absolute; 
			top:0;
			right:0;
			background:url(icon.png);
		}

		.zoom img {
			display: block;
		}

		.zoom img::selection { background-color: transparent; }

		#ex2 img:hover { cursor: url(grab.cur), default; }
		#ex2 img:active { cursor: url(grabbed.cur), default; }
		.img{
			align-content: center;
		}
	</style>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script src='<?=URL_SITE."/application/views/zoom/"?>jquery.zoom.js'></script>
	<script>
		$(document).ready(function(){
			$('#ex1').zoom();
			$('#ex2').zoom({ on:'grab' });
			$('#ex3').zoom({ on:'click' });			 
			$('#ex4').zoom({ on:'toggle' });
		});
	</script>

    <style>
        * {padding:0;margin:0;}

        .float {
            position:fixed;
            display:flex;
            justify-content: center;
            /*cursor: pointer;*/
            align-items: center;
            width:60px;
            height:60px;
            bottom:40px;
            right:40px;
            background: linear-gradient(to right, #F58225, #D75E40);
            color:#FFF;
            border-radius:50px;
            text-align:center;
            box-shadow: 2px 2px 3px #999;
        }
        
        @media (max-width: 768px) {
            .float{
                /*bottom: 60px;
                    right: 20px;*/
                display: none;
            }
        }
    </style>
</body>

<section class="center navigation">
    <div class="menor navigation-bar text-left">
        <a class="page-name">Tópico</a>
        <a class="page-name nav-separator"> | </a>
        <div class="page-path"> 
            <a href="/" class="select-hover">Home</a> > 
            <a href="/materiais" class="select-hover">Materiais</a> > 
            <a class="select-hover">Tópico</a> 
        </div>
    </div>
</section>

<section class="big-spaces-top">
    <script src="<?= URL_SITE ?>assets/js/pages/materialestudo.js?d=<?= date('YmdHis') ?>"></script>
    <div class="container">
        <div class="side-column">
            <?
if (isset($_SESSION['cliente']['id'])):
?>
               <form >
                    <input type="hidden" id="id" value="<?= $id ?>">
                    <div class="cards">
                        <div class="radio-option small-space">
                            <label class="container">
                                <input id="estudado" type="checkbox" name="estudado" <?= ($conteudoLido ? 'checked' : '') ?> >
                                <span class="checkmark"></span>
                                <a class="study-mark">CONTEÚDO <?= (!$conteudoLido ? 'NÃO' : '') ?> ESTUDADO</a>
                            </label>
                        </div>
                    </div>
                </form>
            <?
endif;
?>
           
            <?php
$id_toggle = explode("/", $_SERVER['SCRIPT_URI']);

//include_once(PATH_ABSOLUTO."application/views/components/$id_toggle[5].php");
include_once(PATH_ABSOLUTO . "application/views/components/7.php");
?>    
            
        </div>
        <div class="topico">
            
            <?
if ($conteudo['demonstrativo'] || $classAssinatura->temAcessoBasico() || $liberado1ano || $acesso == 1 || $acesso == 2):
?>
               <a class="topico-title text-gray"><?= $conteudo['titulo'] ?></a>
<!--                 <img class="topico-img" src="<?= $imagem['g'] ?>" alt="" /> -->
                <div class="img-dinamic zoom"id="ex3">                    
                    <img class="topico-img" id="img-dinamic" src="<?= $imagem[0]['g'] ?>" alt=""/>
                </div>
                <div class="media">
                    <ul class="slide">
                        <?
    foreach ($imagem as $img):
?>
                           <li class="item-slide">
                                <img src="<?= $img['g'] ?>" alt="" />
                            </li>
                        <?
    endforeach;
?>
                   </ul>
                </div>
                <p class="content-terms"><?= $conteudo['conteudo'] ?></p>
            <?
elseif ($_SESSION['cliente']['id']):
?>
           
            <a class="topico-title text-gray"><?= $conteudo['titulo'] ?></a>
<!--                 <img class="topico-img" src="<?= $imagem['g'] ?>" alt="" /> -->
                <div class="img-dinamic " id="">                    
                    <img style="-webkit-filter: blur(20px);" class="topico-img" id="img-dinamic" src="<?= $imagem[0]['g'] ?>" alt=""/>
                </div>
                <div class="media">
                    <ul class="slide">
                        <?
    foreach ($imagem as $img):
?>
                           <li class="item-slide">
                                <img style="-webkit-filter: blur(20px);"src="<?= $img['g'] ?>" alt="" />
                            </li>
                        <?
    endforeach;
?>
                   </ul>
                </div>
                <p class="content-terms"><?= $conteudo['conteudo'] ?></p>
            
            <div id="popuplead" style="display:none;">
                    
                    <p>Esse conteúdo é exclusivo para assinantes</p>
                    <p>Assine já para ter acesso ao maior portal jurídico do Brasil</p>
                    <a class="btn orange area-do-assinante orange-hover " style="padding-bottom:0px" href="https://www.entendeudireito.com.br/planos">Assinar</a>
            </div>
            <?
else:
?>
           
            <a class="topico-title text-gray"><?= $conteudo['titulo'] ?></a>
<!--                 <img class="topico-img" src="<?= $imagem['g'] ?>" alt="" /> -->
                <div class="img-dinamic">                    
                    <img style="-webkit-filter: blur(20px);" class="topico-img" id="img-dinamic" src="<?= $imagem[0]['g'] ?>" alt=""/>
                </div>
                <div class="media">
                    <ul class="slide">
                        <?
    foreach ($imagem as $img):
?>
                           <li class="item-slide">
                                <img style="-webkit-filter: blur(20px);"src="<?= $img['g'] ?>" alt="" />
                            </li>
                        <?
    endforeach;
?>
                   </ul>
                </div>
                <p class="content-terms"><?= $conteudo['conteudo'] ?></p>
            
            <div id="popuplead" style="display:none;">
                    <p>Esse conteúdo é exclusivo para usuários cadastrados</p>
                    <p>Assine já para ter acesso ao maior portal jurídico do Brasil</p>
                    <a class="btn orange orange-hover" style="padding-bottom:0px"href="https://www.entendeudireito.com.br/login">Cadastre-se</a>
                
            </div>
        
             <?php
endif;
?>
            <a href="#" onclick="window.history.back();" class="float" style="bottom:100px" >
                <i class="material-icons">
                    arrow_back
                </i>
            </a>
        </div>
        <div class="side-column column-2">
            <div class="print-items">
    
                <?
if ($arquivo && $classAssinatura->temAcessoVip() || $acesso == 2):
?>
                   <a href="#" data-file-id="<?= $arquivo['id'] ?>" class="text-print"><img  class="print" src="<?= URL_SITE ?>assets/images/print.svg" alt="" />
                    <br />Clique <br>para<br>imprimir</a>
                <?
elseif ($vip1ano == 1):
?>
            <a href="#" data-file-id="<?= $arquivo['id'] ?>" class="text-print"><img  class="print" src="<?= URL_SITE ?>assets/images/print.svg" alt="" />
                    <br />Clique <br>para<br>imprimir</a>
             <?
endif;
?>
           </div>
        </div>
        
    </div>
</section>

<?php
include(PATH_ABSOLUTO . "includes/assetsPage.php");
$stylesPage = '<link href="' . URL_SITE . 'assets/css/topico.css" type="text/css" rel="stylesheet" media="screen"/>';
//$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materialestudo.js"></script>';
?>