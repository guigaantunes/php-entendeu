<?php

    $blog['titulo']="titulo";
    $blog['data_formatada']="data";
    $blog['autor']= "Cláudia Rocha Franco Lopes";
    $blog['image_lg'][1] = "imagem1";
    $blog['conteudo1'] = 'texto1';
    $blog['conteudo2'] = 'texto2';



    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<section class="center navigation">
	<div class="menor navigation-bar text-left">
		<a class="page-name">Conteudo</a>
		<a class="page-name nav-separator"> | </a>
		<div class="page-path"> 
			<a href="/" class="select-hover">Home</a> > 
			<a href="/blog" class="select-hover">Blog</a> > 
			<div style="font-size:10px">
			<a class="select-hover"><?=$blog['titulo']?></a> 
			</div>
		</div>
	</div>
</section>

<section class="big-spaces-top">
	<div class="all-content">
		<div class="side-column">
			<?php
				//include_once(PATH_ABSOLUTO."application/views/components/toggle-menu-blog.php");
			?>	
		</div>
		<div class="noticia">
			<a class="noticia-title text-orange"><?=$blog['titulo']?></a>
			<a class="subtitle text-grey"><?=ucfirst($blog['data_formatada'])?> | <?=$blog['autor']?></a>
			<div class="social-bar">
						<div style="font-size:45px"class="share-icons">
							<a href="https://www.facebook.com/Entendeudireito/" target="_blank"><img src="https://logodownload.org/wp-content/uploads/2014/09/facebook-logo-2-1.png" style="width:30px;"></a>
					    <a href="https://api.whatsapp.com/send?phone=556791295622&text=Ol%C3%A1%2C%20vim%20pela%20p%C3%A1gina%20do%20blog" target="_blank"><img src="https://logodownload.org/wp-content/uploads/2015/04/whatsapp-logo-1.png"style="width:30px;"></img></a>
					    <a href="https://www.instagram.com/entendeudireito/" target="_blank"><img src="https://logodownload.org/wp-content/uploads/2017/04/instagram-logo.png"style="width:30px;"></i></a>
						
						</div>
						<a class="compartilhar">Fale conosco</a>
			</div> 
			<?=$blog['conteudo1']?>
			<br>
			<div class="center">
				<img style="margin:0px;width:200px" class="noticia-img" src="<?=$blog['image_lg'][1]?>" alt="" />
				<img style="margin:0px;width:200px" class="noticia-img" src="<?=$blog['image_lg'][2]?>" alt="" />
				<img style="margin:0px;width:200px" class="noticia-img" src="<?=$blog['image_lg'][3]?>" alt="" />
				<img style="margin:0px;width:200px" class="noticia-img" src="<?=$blog['image_lg'][4]?>" alt="" />
			</div>
				<p class="noticia-content">
	    		<?=$blog['conteudo2']?>
	        </p>
	        
		    <div class="social-bar">
				<a class="compartilhar">Compartilhar</a>
				<div class="share-noticia">
						<div class="share-icons">
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?=$current_url?>" target="_blank">
    							<i class="icon-facebok"></i>
    				        </a>
							<a href="https://twitter.com/home?status=<?=$current_url?>" target="_blank">
    							<i class="icon-twitter"></i>
    				        </a>
							<a href="https://plus.google.com/share?url=<?=$current_url?>" target="_blank">
                                <i class="icon-google"></i>
                            </a>
						
						</div>
					
					<a class="back-link text-orange" href="<?=URL_SITE?>blog"> ⬅ Voltar para o Blog </a>
				</div>
			</div>   
			<a class="back-link-small text-orange" href="<?=URL_SITE?>blog"> ⬅ Voltar para o Blog </a> 
		</div>
		
		<div class="side-column">
			<a style="display: none">a</a>
		</div>
	</div>
</section>

<?php 
	include(PATH_ABSOLUTO."includes/assetsPage.php");
	$stylesPage = '<link href="'.URL_SITE.'assets/css/noticia.css" type="text/css" rel="stylesheet" media="screen"/>';
// 	$scriptPage = '<script src="'.URL_SITE.'assets/js/pages/materiais.js"></script>';
?>