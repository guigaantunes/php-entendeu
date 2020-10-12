<?php
    $classBlog  = new Blog;

    $categoria     = (isset($this->parametros[2]) ? $this->parametros[2] : false);

    if (!$categoria) {
        $blogs      = $classBlog->listar();    
    } else {
        $blogs      = $classBlog->listar($categoria); 
    }
/*if($_GET['e']==1){
  $var= json_encode($blogs,false);
  echo $var;
  }*/

?>

<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Blog</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a class="select-hover">Blog</a> 
			
		</div>
	</div>
</section>

<section class="big-spaces-top">
	<div class="all-content">
		<?php
			// include_once(PATH_ABSOLUTO."application/views/components/toggle-menu-blog.php");
		?>	
		<div class="noticias">
	    	<?foreach($blogs as $i => $blog):?>
	    	    <div class="noticia">
	    			<div class="div-img">
	    				<img class="noticia-img div-img" src="<?=$blog['image_lg']?>" alt="" />
	    			</div>
	    			<div class="noticia-text">
	    				<a class="titulo-noticia"><?=$blog['titulo']?><br></a>
	    				<span class="infos-noticia"><?=ucfirst($blog['data_formatada'])?> | <?=$blog['autor']?></span>
	    				<p class="conteudo-noticia"><?echo strip_tags( strlen(html_entity_decode($blog['conteudo'])) > 300 ? substr(html_entity_decode($blog['conteudo']),0, 300).'...' : html_entity_decode($blog['conteudo']) )?></p>
	    				<div>
	    					<a class="btn green btn-small green-hover" href="/conteudo/<?=$blog['url']?>">Ver matéria completa</a>
	    				</div>
	    			</div>
	    		</div>
	    	<?endforeach;?>
	<!--
			<div class="noticia">
				<div class="">
					<img class="noticia-img" src="<?=URL_SITE?>assets/images/img1.png" alt="" />
				</div>
				<div class="noticia-text">
					<a class="titulo-noticia">Conduta - Ação ou omissão<br></a>
					<span class="infos-noticia">October 26, 2018 | Cláudia Rocha Franco Lopes</span>
					<p class="conteudo-noticia">Para o direito penal, que não se ocupa de atos fortuitos e de força maior, os delitos surgem das condutas humanas, sempre classificáveis como ação (agir positivo) ou omissão (agir negativo). A conduta ou ação é um comportamento humano, observado pelo Direito. É necessário que ação…</p>
					<div>
						<a class="btn green btn-small" href="<?=URL_SITE?>noticia">Ver matéria completa</a>
					</div>
				</div>
			</div>
			
			<div class="noticia">
				<div class="">
					<img class="noticia-img" src="<?=URL_SITE?>assets/images/img2.png" alt="" />
				</div>
				<div class="noticia-text">
					<a class="titulo-noticia">Conduta - Ação ou omissão<br></a>
					<span class="infos-noticia">October 26, 2018 | Cláudia Rocha Franco Lopes</span>
					<p class="conteudo-noticia">Para o direito penal, que não se ocupa de atos fortuitos e de força maior, os delitos surgem das condutas humanas, sempre classificáveis como ação (agir positivo) ou omissão (agir negativo). A conduta ou ação é um comportamento humano, observado pelo Direito. É necessário que ação…</p>
					<div>
						<a class="btn green btn-small" href="<?=URL_SITE?>noticia">Ver matéria completa</a>
					</div>
				</div>
			</div>
			
			<div class="noticia">
				<div class="">
					<img class="noticia-img" src="<?=URL_SITE?>assets/images/img1.png" alt="" />
				</div>
				<div class="noticia-text">
					<a class="titulo-noticia">Conduta - Ação ou omissão<br></a>
					<span class="infos-noticia">October 26, 2018 | Cláudia Rocha Franco Lopes</span>
					<p class="conteudo-noticia">Para o direito penal, que não se ocupa de atos fortuitos e de força maior, os delitos surgem das condutas humanas, sempre classificáveis como ação (agir positivo) ou omissão (agir negativo). A conduta ou ação é um comportamento humano, observado pelo Direito. É necessário que ação…</p>
					<div>
						<a class="btn green btn-small" href="<?=URL_SITE?>noticia">Ver matéria completa</a>
					</div>
				</div>
			</div>
	-->
		</div>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/blog.css" type="text/css" rel="stylesheet" media="screen"/>';
// 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materiais.js"></script>';
?>