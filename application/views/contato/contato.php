<?php
    $classConfiguracao  = new Configuracao;
    $classConteudo      = new Conteudo;
    
    $configuracoes      = $classConfiguracao->getById(1);
    
    $conteudoContato    = $classConteudo->getById(5);
?>
<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Contato</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a class="select-hover">Contato</a> 
			
		</div>
	</div>
</section>

<section class="section-space">
	<div class="contato">
		
		<div class="half-size center">
			<img class="cartoon full-size" src="<?=URL_SITE?>assets/images/contato.png" alt=""/>
		</div>
		
		
		<div class="half-size">
			<a class="title text-gray left"><?=$conteudoContato['titulo']?></a>
			<p class="big-text text-gray"><?=$conteudoContato['conteudo']?></p>
			<form  class="form" id='form-login' action="/ajax/ajax.contato.php" method="POST">
				<div class="input-field required" data-error="Informe seu nome">
	    			<input id="nome" type="text" name="nome" placeholder="Nome" class="required" value="<?=( isset($_SESSION['admin']['id']) ? $_SESSION['cliente']['nome'] : '')?>" />
	    		</div>
	    		<div class="input-field required" data-error="Informe seu email">
	    			<input id="email" type="text" name="email" placeholder="E-mail" class="required" value="<?=( isset($_SESSION['admin']['id']) ? $_SESSION['cliente']['email'] : '')?>"/>
	    		</div>
	    		<div class="input-field required" data-error="Informe seu telefone">
	    			<input id="telefone" type="text" name="telefone" placeholder="Telefone" class="required mask-telefone" value="<?=( isset($_SESSION['admin']['id']) ? $_SESSION['cliente']['telefone'] : '')?>"/>
	    		</div>
	    		<div class="input-field">
					<textarea id="msg" type="text" name="msg" placeholder="Mensagem" rows="1" oninput='if(this.scrollHeight > this.offsetHeight && this.rows < 4) this.rows += 1'></textarea>
				</div>
	    		<div class="input-field required" >
		    		<a href="javascript:void(0)" class="btn btn-send" id='btn-send'>enviar</a>
	    		</div>
	    		<div class="enviar">
    				<button type="submit" class="btn gray btn-small">Enviar Mensagem</button>
    			</div>
			</form>
<!--
			<div class="enviar">
				<a class="btn gray btn-small">Enviar Mensagem</a>
			</div>
-->
			<?if($configuracoes['facebook'] || $configuracoes['instagram']):?>
			<div class="flex">
				<div class="half chamada">
					<a class="big-text text-gray left">Você também pode entrar em contato conosco pelas nossas redes sociais:</a
				</div>
				<div class="flex">
    				<?if($configuracoes['facebook']):?>
					    <a href="https://facebook.com/<?=$configuracoes['facebook']?>" target="_blank"><i class="icon-fb-quadrado-15 text-orange contato-icon fb"></i></a>
					<?endif;?>
					<?if($configuracoes['instagram']):?>
					    <a href="https://instagram.com/<?=$configuracoes['instagram']?>" target="_blank"><i class="icon-instagram text-orange contato-icon"></i></a>
                    <?endif;?>
				</div>
			</div>
			<?endif;?>		
        </div>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/principal.css" type="text/css" rel="stylesheet" media="screen"/>';
 	//$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/faq.js"></script>';
?>