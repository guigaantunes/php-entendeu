<?php
    $classBlog  = new Blog;

    $categoria     = (isset($this->parametros[2]) ? $this->parametros[2] : false);

    if (!$categoria) {
        $blogs      = $classBlog->listar();    
    } else {
        $blogs      = $classBlog->listar($categoria); 
    }
?>
<div class="all-content">
		<?php
			// include_once(PATH_ABSOLUTO."application/views/components/toggle-menu-blog.php");
		?>	
		<div class="noticias">
	    	<?
      $count=0;
      foreach($blogs as $i => $blog):
      if($count<5){
      $count+=1;?>
	    	    <div style="flex-direction:row;" class="noticia">
	    			<div style="width:100px;height: 100px;"  class="div-img">
	    				<img style="width:100px;margin:0px;"class="noticia-img div-img" src="<?=$blog['image']?>" alt="" />
	    			</div>
	    			<div style="font-size:10px;" class="noticia-text">
	    				<a class="titulo-noticia"><?=$blog['titulo']?><br></a>
	    				<span class="infos-noticia"><?=ucfirst($blog['data_formatada'])?> | <?=$blog['autor']?></span>
	    				<div>
	    					<a style="font-size:10px;"class="btn green btn-small green-hover" href="/conteudo/<?=$blog['url']?>">Ver matéria completa</a>
	    				</div>
	    			</div>
	    		</div>
	    	<?}endforeach;?>
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