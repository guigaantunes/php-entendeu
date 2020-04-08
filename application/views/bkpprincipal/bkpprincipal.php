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
?>

<section class="menor" >
		<div class=" center" style="background-color:#FFD191">
		    <a href="https://entendeudireito.com.br/login"><img style="width:100%"src="<?=URL_SITE?>application/views/principal/banner.png"  alt=""/></a>	
		</div>
</section>

<section class="section-space">
	<div class="container">
		<div class="planos">
		<div class="half center">
			<img class="cartoon full-size" src="<?=URL_SITE?>assets/images/planos.png" alt=""/>
		</div>
		
		<div class="half">
			<a class="title text-orange left"><?=$conteudoPlanos['titulo']?></a>
			<p class="big-text text-gray"><?=$conteudoPlanos['conteudo']?></p>
		</div>
	</div>
	   
	
</section>

<section class="spaces">
	<div class="vantagens">
		<div class="half title-vantagens">
			<a class="title text-white"><?=$conteudoVantagens['titulo']?></a>
		</div>
		
		<div class="separator"></div>
		
		<div class="half">
			<p class="big-text text-white"><?=$conteudoVantagens['conteudo']?></p>
		</div>
	</div>
</section>

<section class="section-space">
	<div class="blog">
		<div class="section-name">
		<a class="title text-orange text-left">Últimas do nosso Blog</a>
		</div>
		<div class="noticias">
			<div class="swiper-container swiper-blog">
			    <!-- Additional required wrapper -->
			    <div class="swiper-wrapper">
			        <!-- Slides -->
			        <?foreach($blogs as $i => $blog):?>
	            <div class="noticia swiper-slide">
		            <div class="content-noticia">
	    						<a class="titulo-noticia"><?=$blog['titulo']?><br></a>
	    						<span class="infos-noticia"><?=ucfirst($blog['data_formatada'])?> | <?=$blog['autor']?></span>
	    						<p class="conteudo-noticia"><?=( strlen(semHtml($blog['conteudo'])) > 300 ? substr(semHtml($blog['conteudo']),0, 300).'...' : semHtml($blog['conteudo']) )?></p>
    						</div>
    						<div class="buttom-noticia">
    							<a href="/conteudo/<?=$blog['url']?>" class="btn green btn-small green-hover">Ver matéria completa</a>
    						</div>
    					</div>
			        <?endforeach;?>
			    </div>	
			</div>
		</div>
		<div class="swiper-pagination bullets"></div>
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
	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/principal.js"></script>';
?>