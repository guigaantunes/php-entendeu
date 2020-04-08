<?php
    //$Pagseguro          = new Pagseguro;
    
    $class              = new MaterialEstudo;
    $classLido          = new ClienteLeuMaterial;
    $classAssinatura    = new Assinatura;
    
    $id = $this->parametros[1];
    $conteudo = $class->getById($id);
    
    $imagem = $class->getImages($id);
    $imagem = end($imagem);
    
    $arquivo = $class->getFiles($id);
    $arquivo = end($arquivo);
    
    $conteudoLido = $classLido->materialLido($id);
	$video = $conteudo['video'];
	$idVideo = soNumero($video);
	$html = '<iframe width="900" height="300" src="https://player.vimeo.com/video/'.$idVideo.'"frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	$assinatura = $classAssinatura->getAssinatura();
	
	
	//$Pagseguro->getPlanInfo();
	//$Pagseguro->createPlan();

?>

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
    <script src="<?=URL_SITE?>assets/js/pages/materialestudo.js?d=<?=date('YmdHis')?>"></script>
	<div class="all-content">
		<div class="side-column">
    		<?if( isset($_SESSION['cliente']['id']) ):?>
    			<!--
        		<form >
            		<input type="hidden" id="id" value="<?=$id?>">
        			<div class="cards">
        	    		<div class="radio-option small-space">
        		    		<label class="container">
                                <input id="estudado" type="checkbox" name="estudado" <?=($conteudoLido ? 'checked' : '')?> >
                                <span class="checkmark"></span>
                                <a class="study-mark">CONTEÚDO <?=(!$conteudoLido ? 'NÃO' : '')?> ESTUDADO</a>
        					</label>
        	    		</div>
        			</div>
        		</form>
        		!-->
    		<?endif;?>
			
			<?php
    			
				include_once(PATH_ABSOLUTO."application/views/components/toggle-menu-material.php");
			?>	
			
		</div>
		<div class="topico">
			<?if( isset($_SESSION['cliente']['id']) ):?>
				<a class="topico-title text-gray"><?=$conteudo['titulo']?></a>
				<img class="topico-img" src="<?=$imagem['g']?>" alt="" />
				<p class="content-terms"><?=$conteudo['conteudo']?></p>
			<?else:?>
				<a class="topico-title conteudo-amostra"><?=$conteudo['titulo']?></a>
				<img class="topico-img" src="<?=$imagem['g']?>" alt="" />
				<p class="content-terms">Os conteúdos disponibilizados nessa página não estão completos por ser uma versão apenas de teste para usuários que ainda não adquiriram um de nossos planos.</p>
			<?endif;?>
			<?php
				if($video && $assinatura['vip'] && $classAssinatura->assinaturaAtiva()):
			?>
			 <div class="embed"><?=$html?></div>
			 <?php
				 endif;
			 ?>
		<a class="back-link text-orange" href="<?=URL_SITE?>materiais"> ⬅ Voltar para Lista de Tópicos</a>
		</div>
		<div class="side-column column-2">
			<div class="print-items">
    			
				<?if( isset($_SESSION['cliente']['id']) && $arquivo && $classAssinatura->assinaturaAtiva()):?>
					<img class="print" src="<?=URL_SITE?>assets/images/print.svg" alt="" />
					<a href="#" data-file-id="<?=$arquivo['id']?>" class="text-print">Clique <br>para<br>imprimir</a>
				<?endif;?>
			</div>
		</div>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/topico.css" type="text/css" rel="stylesheet" media="screen"/>';
 	//$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materialestudo.js"></script>';
?>

